<?php
namespace App\Http\Controllers\Api\Clients;
use App\Models\Reservation;
use App\Models\ReservationDetail;
use App\Models\ReservationLimit;
use App\Models\Product;
use App\Models\Currency;
use App\Models\Agency;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\ReservationLimitResource;
use App\Http\Requests\ReservationSaveRequest;

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
        foreach($params["details"] as $value){
            ReservationDetail::create([
                "reservation_id" => $reservation->id,
                "amount" => $value["amount"],
                "discount" => $value["discount"],
                "quantity" => $value["quantity"],
                "product_id" => $value["product_id"],
                "currency_id" => $reservation->currency_id,
            ]);
        };
        return new ReservationResource($reservation);
    }

    public function availabilities(){
        return ReservationLimitResource::collection(ReservationLimit::orderBy('date','desc')->get());
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
    
}