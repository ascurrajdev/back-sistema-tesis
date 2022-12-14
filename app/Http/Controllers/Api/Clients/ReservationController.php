<?php
namespace App\Http\Controllers\Api\Clients;
use App\Models\Reservation;
use App\Models\ReservationDetail;
use App\Models\ReservationLimit;
use App\Models\Product;
use App\Models\Currency;
use App\Models\Agency;
use App\Models\ReservationConfig;
use App\Models\InvoiceDue;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationConfigResource;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\ReservationLimitResource;
use App\Http\Requests\ReservationSaveRequest;
use App\Http\Resources\ProductResource;

class ReservationController extends Controller{
    use ResponseTrait;

    public function index(Request $request){
        $client = $request->user();
        $reservations = Reservation::query();
        $reservations->with(['reservationDetail','agency','currency']);
        $reservations->client($client->id);
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
        foreach($params["details"] as $key => $detail){
            $productSelected = $products->where("id",$detail["product_id"])->first();
            if($productSelected->is_lodging){
                $reservationArray['quantity_people'] += $detail['quantity'];
            }
            $params["details"][$key]["amount"] = $productSelected->amount;
            $params["details"][$key]["discount"] = 0;
            $reservationArray["total_amount"] += $productSelected["amount"] * $detail["quantity"];
        }
        $reservation = Reservation::create($reservationArray);
        $reservationDetails = array();
        foreach($params["details"] as $value){
            $reservationDetails[] = ReservationDetail::create([
                "reservation_id" => $reservation->id,
                "amount" => $value["amount"],
                "discount" => $value["discount"],
                "quantity" => $value["quantity"],
                "product_id" => $value["product_id"],
                "currency_id" => $reservation->currency_id,
            ]);
        };
        $this->calculateConfigsReservation($reservation);
        $reservation->load('invoiceDue');
        return new ReservationResource($reservation);
    }

    private function calculateConfigsReservation($reservation){
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