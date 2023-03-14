<?php
namespace App\Http\Controllers\Api\Clients;

use App\Contracts\PaymentService;
use App\Models\Reservation;
use App\Models\ReservationLimit;
use App\Models\Product;
use App\Models\Currency;
use App\Models\Agency;
use App\Models\ReservationConfig;
use App\Models\InvoiceDue;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationConfigResource;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\ReservationLimitResource;
use App\Http\Requests\ReservationSaveRequest;
use App\Http\Resources\collections\ReservationBillingCollection;
use DB;
use Log;
use App\Http\Resources\ProductResource;
use App\Models\Collection;

class ReservationController extends Controller{
    use ResponseTrait;

    private $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }
    public function index(Request $request){
        $client = $request->user();
        $reservations = Reservation::query();
        $reservations->with(['reservationDetail','agency','currency']);
        $reservations->client($client->id);
        foreach($request->query() as $key => $value){
            $reservations->{$key}($value);
        }
        $reservations->orderBy('id','desc');
        $reservationsList = $reservations->paginate();
        return ReservationResource::collection($reservationsList);
    }

    public function store(ReservationSaveRequest $request){
        $params = $request->validated();
        $currency = Currency::firstWhere("default",true);
        $agency = Agency::firstWhere("active_for_reservations_online",true);
        $reservationArray = [
            "client_id" => $request->user()->id,
            "date_from" => $params["date_from"],
            "date_to" => $params["date_to"],
            "total_amount" => 0,
            "total_discount" => 0,
            "notes" => $params["notes"] ?? "",
            "currency_id" => $currency->id,
            "agency_id" => $agency->id,
            'quantity_people' => 0,
        ];
        $productIds = collect($params["details"])->map(function($value){ 
            return $value["product_id"];
        })->all();
        $products = Product::whereIn("id",$productIds)->get();
        $totalAmountUntaxed = 0;
        foreach($params["details"] as $key => $detail){
            $productSelected = $products->where("id",$detail["product_id"])->first();
            if($productSelected->is_lodging){
                $reservationArray['quantity_people'] += $detail['quantity'];
            }
            $params["details"][$key]["amount"] = $productSelected->amount;
            $params["details"][$key]["discount"] = 0;
            $params["details"][$key]["amount_discount"] = 0;
            $params["details"][$key]["currency_id"] = $reservationArray['currency_id'];
            $params["details"][$key]["tax_id"] = $productSelected->tax_id;
            $params["details"][$key]["tax_rate"] = $productSelected->tax_rate;
            $params["details"][$key]["amount_untaxed"] = $productSelected->amount - ($productSelected->amount / 11 * $productSelected->tax_rate);
            $reservationArray["total_amount"] += $productSelected["amount"] * $detail["quantity"];
            $totalAmountUntaxed += $productSelected->amount / 11 * $productSelected->tax_rate;
        }
        $reservation = Reservation::create($reservationArray);
        $invoice = Invoice::create([
            'reservation_id' => $reservation->id,
            'total_amount' => $reservationArray['total_amount'],
            'total_discount' => $reservationArray['total_discount'],
            'total_paid' => 0,
            'paid_cancelled' => false,
            'operation_type' => 'credito',
            'expiration_date' => $reservationArray['date_to'],
            'currency_id' => $reservationArray['currency_id'],
            'agency_id' => $reservationArray['agency_id'],
            'client_id' => $reservationArray['client_id'],
            'total_amount_untaxed' => $totalAmountUntaxed,
        ]);
        $reservationDetails = array();
        $invoiceDetails = array();
        foreach($params["details"] as $value){
            $reservationDetails[] = [
                "amount" => $value["amount"],
                "discount" => $value["discount"],
                "quantity" => $value["quantity"],
                "product_id" => $value["product_id"],
                "currency_id" => $reservation->currency_id,
            ];
            $invoiceDetails[] = [
                'product_id' => $value['product_id'],
                'currency_id' => $value['currency_id'],
                'tax_id' => $value['tax_id'],
                'tax_rate' => $value['tax_rate'],
                'amount' => $value['amount'],
                'amount_untaxed' => $value['amount_untaxed'],
                'amount_discount' => $value['amount_discount'],
                'quantity' => $value['quantity'],
            ];
        };
        $invoice->details()->createMany($invoiceDetails);
        $reservation->reservationDetail()->createMany($reservationDetails);
        $this->calculateConfigsReservation($reservation, $invoice);
        $reservation->load('invoiceDue');
        return new ReservationResource($reservation);
    }

    private function calculateConfigsReservation($reservation, $invoice){
        $reservationConfig = ReservationConfig::firstWhere('active',true);
        if(empty($reservationConfig)){
            $reservationConfig = ReservationConfig::create([
                'is_partial_payment' => config('reservation.limits.default.is_partial_payment'),
                'initial_payment_percent' => config('reservation.limits.default.initial_payment_percent'),
                'max_quantity_quotes' => config('reservation.limits.default.max_quantity_quotes'),
                'max_days_expiration_initial_payment' => config('reservation.limits.default.max_days_expiration_initial_payment'),
            ]);
        }
        if($reservationConfig->is_partial_payment){
            InvoiceDue::create([
                'number_due' => 1,
                'invoice_id' => $invoice->id,
                'amount' => $reservation->total_amount * $reservationConfig->initial_payment_percent / 100,
                'expiration_date' => now()->addDays($reservationConfig->max_days_expiration_initial_payment),
                'reservation_id' => $reservation->id,
                'is_initial_reservation_payment' => true,
                'currency_id' => $reservation->currency_id,
                'agency_id' => $reservation->agency_id,
            ]);
        }
    }

    public function availabilities(Request $request){
        $reservationsLimit = ReservationLimit::query();
        $availablesFilters = ['quantity'];
        $request->collect()->map(function($value, $key) use ($reservationsLimit,$availablesFilters){
            if(in_array($key,$availablesFilters)) $reservationsLimit->{$key}($value);
        });
        $reservationsLimit = $reservationsLimit->orderBy('date','desc')->get();
        return ReservationLimitResource::collection($reservationsLimit);
    }

    public function view(Reservation $reservation, Request $request){
        $this->authorizeForUser($request->user(),"view",$reservation);
        $reservation->load(['reservationDetail','agency','currency']);
        return new ReservationResource($reservation);
    }

    public function makePayment(Reservation $reservation, Request $request){
        $request->validate([
            'amount' => ['required','integer']
        ]);
        $invoices = $reservation->invoices()
        ->where('operation_type','credito')
        ->where('paid_cancelled',false)
        ->get();
        $amountPaid = $request->amount;
        $invoicesSelected = [];
        foreach($invoices as $invoice){
            $balance = $invoice->total_amount - $invoice->total_paid;
            if($amountPaid > 0){
                if($balance > $amountPaid){
                    $invoicesSelected[] = [
                        'number_due' => 1,
                        'invoice_id' => $invoice->id,
                        'reservation_id' => $reservation->id,
                        'amount' => $amountPaid,
                        'currency_id' => $invoice->currency_id,
                        'agency_id' => $invoice->agency_id,
                        'expiration_date' => now()->addDay(1),
                        'is_initial_reservation_payment' => 0,
                    ];
                    $amountPaid = 0; 
                }else if($balance < $amountPaid){
                    $invoicesSelected[] = [
                        'number_due' => 1,
                        'invoice_id' => $invoice->id,
                        'reservation_id' => $reservation->id,
                        'amount' => $balance,
                        'currency_id' => $invoice->currency_id,
                        'agency_id' => $invoice->agency_id,
                        'expiration_date' => now()->addDay(1),
                        'is_initial_reservation_payment' => 0,
                    ];
                    $amountPaid -= $balance;
                }
            }
        }
        $invoiceDues = [];
        foreach($invoicesSelected as $invoice){
            $invoiceDue = InvoiceDue::create($invoice);
            $invoiceDues[] = $invoiceDue;
        }
        $collection = Collection::create([
            'total_amount' => $request->amount,
            'total_amount_paid' => 0,
            'is_paid' => 0,
            'currency_id' => $invoiceDues[0]->currency_id,
            'agency_id' => $invoiceDues[0]->agency_id,
            'client_id' => $request->user()->id,
        ]);
        $collectionDetails = [];
        foreach($invoiceDues as $invoiceDue){
            $collectionDetails[] = [
                'invoice_due_id' => $invoiceDue->id,
                'concept' => "Pago por adelanto de la Reservacion {$reservation->id}",
                'currency_id' => $invoiceDue->currency_id,
                'amount' => $invoiceDue->amount,
            ];
        }
        $collection->details()->createMany($collectionDetails);
        $paymentLink = $this->paymentService->createLinkPayment($request->user(),$collection->total_amount,"Pago adelantado por la Reservacion {$reservation->id}");
        $collection->link_payment = $paymentLink['redirect_url'];
        $collection->hook_alias_payment = $paymentLink['merchant_checkout_token'];
        $collection->payment_online_id = $paymentLink['id'];
        $collection->save();
        return $this->success($collection->link_payment);
    }

    public function billing(Reservation $reservation, Request $request){
        $this->authorizeForUser($request->user(),"view",$reservation);
        $reservationId = $reservation->id;
        $collections = DB::table('collections')
        ->whereRaw("id in (SELECT collection_id From collection_details where invoice_due_id in (select id from invoice_dues where reservation_id = ?))",[$reservationId])
        ->whereRaw("is_paid = true")
        ->get();
        $totalReservation = DB::table('invoices')->selectRaw('sum(total_amount - total_paid) as total')
        ->whereRaw('reservation_id in (?)',[$reservationId])
        ->first();
        return (new ReservationBillingCollection($collections->all()))->additional([
            'amount_pending_paid' => $totalReservation->total
        ]);
    }

    public function update(Reservation $reservation, Request $request){
        $request->validate([
            'date_from' => ['before_or_equal:date_to'],
            'date_to' => ['after_or_equal:date_from'],
            'notes' => ['string'],
            'details' => ['array:quantity,product_id']
        ]);
        $this->authorizeForUser($request->user(),"update",$reservation);
        $reservation->update($request->all());
        return new ReservationResource($reservation);
    }
    
    public function products(){
        $products = Product::where([
            ['active_for_reservation', '=', true],
            ['is_lodging', '=', true]
        ])->with(['currency'])->get();
        return ProductResource::collection($products);
    }

    public function config(){
        $reservationConfig = ReservationConfig::firstWhere('active',true);
        if(empty($reservationConfig)){
            $reservationConfig = ReservationConfig::create([
                'is_partial_payment' => config('reservation.limits.default.is_partial_payment'),
                'initial_payment_percent' => config('reservation.limits.default.initial_payment_percent'),
                'max_quantity_quotes' => config('reservation.limits.default.max_quantity_quotes'),
                'max_days_expiration_initial_payment' => config('reservation.limits.default.max_days_expiration_initial_payment'),
            ]);
        }
        return new ReservationConfigResource($reservationConfig);
    }
}