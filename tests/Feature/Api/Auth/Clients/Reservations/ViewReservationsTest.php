<?php

namespace Tests\Feature\Api\Auth\Clients\Reservations;

use Tests\TestCase;
use App\Models\Client;
use App\Models\Reservation;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewReservationsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_view_a_reservation_with_same_client()
    {
        $client = Client::factory()->create();
        $reservation = Reservation::factory()
        ->for($client)
        ->create();
        Sanctum::actingAs(
            $client, 
            ['*']
        );
        $response = $this->getJson(route('api.clients.reservations.view',$reservation));
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function cannot_view_a_reservation_with_other_client()
    {
        $client = Client::factory()->create();
        $reservation = Reservation::factory()
        ->create();
        Sanctum::actingAs(
            $client, 
            ['*']
        );
        $response = $this->getJson(route('api.clients.reservations.view',$reservation));
        $response->assertForbidden();
    }
}
