<?php

namespace Tests\Feature\Api\Auth\Clients\Reservations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Client;
use Laravel\Sanctum\Sanctum;

class GetConfigTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_get_config_of_reservations()
    {
        $client = Client::factory()->create();
        Sanctum::actingAs($client,['*']);
        $response = $this->getJson(route('api.clients.reservations.config'));
        $response->assertSuccessful();
    }
}
