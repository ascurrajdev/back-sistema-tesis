<?php

namespace Tests\Feature\Api\Auth\Users\Agencies;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class CreateAgenciesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_create_a_agency_with_a_user_with_permissions()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,['agencies-store']);
        $response = $this->postJson(route('api.users.agencies.store'),[
            'name' => 'Casa Central',
            'active' => true,
            'city' => 'Asuncion',
            'address' => 'Veteranos del Chacho c/ Carios 158',
            'neighborhood' => 'San Pablo',
        ]);
        $response->assertSuccessful();
        $this->assertDatabaseCount('agencies',1);
    }

    /**
     * @test
     */
    public function cannot_create_a_agency_with_a_user_without_permissions()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,['agencies']);
        $response = $this->postJson(route('api.users.agencies.store'),[
            'name' => 'Casa Central',
            'active' => true,
            'city' => 'Asuncion',
            'address' => 'Veteranos del Chacho c/ Carios 158',
            'neighborhood' => 'San Pablo',
        ]);
        $response->assertForbidden();
        $this->assertDatabaseCount('agencies',0);
    }
}
