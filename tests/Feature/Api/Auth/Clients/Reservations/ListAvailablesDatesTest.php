<?php

namespace Tests\Feature\Api\Auth\Clients\Reservations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\ReservationLimit;
use App\Models\Client;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ListAvailablesDatesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_list_all_availabilities_of_reservations()
    {
        Sanctum::actingAs(Client::factory()->create(),["*"]);
        ReservationLimit::factory()->count(8)->create();
        $response = $this->getJson(route('api.clients.reservations.availabilities'));
        $response->assertStatus(200);
        $response->assertJsonCount(8,"data");
        $response->assertJsonStructure([
            "data" => [
                '*' => [
                    "id",
                    "date",
                    "capacity_min",
                    "capacity_max",
                    "available",
                    "product_id"
                ]
            ]
        ]);
    }
    /**
     * @test
     */
    public function can_list_all_availabilities_of_reservations_with_params_query()
    {
        Sanctum::actingAs(Client::factory()->create(),["*"]);
        ReservationLimit::factory()->count(8)->create();
        $response = $this->getJson(route('api.clients.reservations.availabilities',[
            'quantity' => 10
        ]));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data" => [
                '*' => [
                    "id",
                    "date",
                    "capacity_min",
                    "capacity_max",
                    "available",
                    "product_id"
                ]
            ]
        ]);
    }
}
