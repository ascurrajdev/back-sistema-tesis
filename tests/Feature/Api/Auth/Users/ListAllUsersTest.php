<?php

namespace Tests\Feature\Api\Auth\Users;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ListAllUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_list_all_users_with_a_user_with_permissions()
    {
        $user = User::factory()->create();
        User::factory()->count(10)->create();
        Sanctum::actingAs($user,['*']);
        $response = $this->getJson(route('api.users.index'));
        $response->assertSuccessful();
        $this->assertDatabaseCount('users',11);
    }

    /**
     * @test
     */
    public function cannot_list_all_users_with_a_user_without_permissions()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,['users']);
        $response = $this->getJson(route('api.users.index'));
        $response->assertForbidden();
    }
}
