<?php
namespace App\Http\Controllers\Api\Clients;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
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
        $reservation = Reservation::create([
            "client_id" => $request->user()->id,
            "date_from" => $params["date_from"],
            "date_to" => $params["date_to"],
            "total_amount" => 0,
            "total_discount" => 0,
            "notes" => $params["notes"] ?? "",
            "currency_id" => 1,
            "agency_id" => 1,
        ]);
        return new ReservationResource($reservation);
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