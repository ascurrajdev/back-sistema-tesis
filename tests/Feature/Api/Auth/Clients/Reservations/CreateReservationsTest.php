<?php

namespace Tests\Feature\Api\Auth\Clients\Reservations;

use Tests\TestCase;
use App\Models\Agency;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Product;
use App\Models\ReservationLimit;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateReservationsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function cannot_store_a_reservation_with_unathorized_user()
    {
        $response = $this->postJson(route("api.clients.reservations.store"),[
            "date_from" => "2015-01-01",
            "date_to" => "2015-01-06"
        ]);
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function can_store_a_reservation_with_user()
    {
        Agency::factory()->create();
        Currency::factory()->create();
        Product::factory()->create();
        Sanctum::actingAs(
            Client::factory()->create(),
            ["*"]
        );
        $response = $this->postJson(route("api.clients.reservations.store"),[
            "date_from" => "2015-01-01",
            "date_to" => "2015-01-06",
            "notes" => "Hola",
            "details" => [
                [
                    "product_id" => 1,
                    "quantity" => 1,
                ]
            ]
        ]);
        $response->assertCreated();
        $this->assertDatabaseCount("reservation_details",1);
        $this->assertDatabaseCount("reservation_limits",6);
    }
}
