<?php

namespace Tests\Feature\Api\Auth\Users\Agencies;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Agency;
use Laravel\Sanctum\Sanctum;

class UpdateAgenciesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_update_a_agency_with_a_user_with_permissions()
    {
        $agency = Agency::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user,['agencies-update']);
        $response = $this->putJson(route('api.users.agencies.update',$agency),[
            'name' => 'Casa Matriz'
        ]);
        $response->assertSuccessful();
        $this->assertDatabaseHas("agencies",[
            'id' => $agency->id,
            'name' => 'Casa Matriz'
        ]);
    }

    /**
     * @test
     */
    public function cannot_update_a_agency_with_a_user_without_permissions()
    {
        $agency = Agency::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user,['agencies']);
        $response = $this->putJson(route('api.users.agencies.update',$agency),[
            'name' => 'Casa Matriz'
        ]);
        $response->assertForbidden();
        $this->assertDatabaseMissing("agencies",[
            'id' => $agency->id,
            'name' => 'Casa Matriz'
        ]);
    }
}
