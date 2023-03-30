<?php

namespace Tests\Feature\Api\Auth\Users\Reservations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ListReservationsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_list_all_reservations_with_user_with_ability()
    {
        Sanctum::actingAs(User::factory()->create(),[
            'reservations-index'
        ]);
        $response = $this->getJson(route('api.users.reservations.index'));
        $response->assertStatus(200);
    }
}
