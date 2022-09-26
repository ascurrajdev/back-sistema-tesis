<?php

namespace Tests\Feature\Api\Auth\Users\Roles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Tests\TestCase;

class CreateRolesUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_store_a_role_user_with_a_user_with_permissions()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,["*"]);
        $response = $this->postJson(route('api.users.roles.store'),[
            'name' => 'Nose',
            'abilities' => [
                'products-index'
            ]
        ]);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'abilities'
            ]
        ]);
        $this->assertDatabaseCount('role_users',1);
    }

    /**
     * @test
     */
    public function cannot_store_a_role_user_with_a_user_without_permissions()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,["products"]);
        $response = $this->postJson(route('api.users.roles.store'),[
            'name' => 'Nose',
            'abilities' => [
                'products-index'
            ]
        ]);
        $response->assertForbidden();
    }
}
