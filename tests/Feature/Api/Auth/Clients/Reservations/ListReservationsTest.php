<?php

namespace Tests\Feature\Api\Auth\Clients\Reservations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use App\Models\Client;
use Tests\TestCase;
use App\Models\Reservation;

class ListReservationsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function cannot_ghost_user_list_all_reservations()
    {
        $response = $this->getJson(route("api.clients.reservations.index"));
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function can_authenticated_user_list_all_reservations(){
        $client = Client::factory()->create();
        Reservation::factory()
        ->for($client)
        ->create();
        Sanctum::actingAs(
            $client,
            ["*"]
        );
        $response = $this->getJson(route("api.clients.reservations.index"));
        $response->assertSuccessful();
        $response->assertJsonCount(1,"data");
        $response->assertJsonStructure([
            "data",
            "links",
            "meta",
        ]);
    }

}
