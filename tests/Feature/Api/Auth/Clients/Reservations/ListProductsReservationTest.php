<?php

namespace Tests\Feature\Api\Auth\Clients\Reservations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Client;
use Laravel\Sanctum\Sanctum;
use App\Models\Product;
use Tests\TestCase;

class ListProductsReservationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_list_all_products_for_reservation()
    {
        Product::factory()->create();
        $client = Client::factory()->create();
        Sanctum::actingAs($client,['*']);
        $response = $this->getJson(route('api.clients.reservations.products'));
        $response->assertSuccessful();
    }
}
