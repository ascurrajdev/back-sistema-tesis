<?php

namespace Tests\Feature\Api\Auth\Clients;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Client;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateClientTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_update_current_client()
    {
        $client = Client::factory()->create();
        Sanctum::actingAs($client,["*"]);
        $response = $this->putJson(route('api.clients.update'),[
            'name' => 'Fulanito'
        ]);
        $response->assertStatus(200);
    }

}
