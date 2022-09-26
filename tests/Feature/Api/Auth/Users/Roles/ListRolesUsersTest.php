<?php

namespace Tests\Feature\Api\Auth\Users\Roles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\RoleUser;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ListRolesUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_list_all_roles_users_with_user_with_permissions()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,['roles-users-index']);
        RoleUser::factory()->count(5)->create();
        $response = $this->getJson(route('api.users.roles.index'));
        $response->assertSuccessful();
        $response->assertJsonCount(5,"data");
    }

    /**
     * @test
     */
    public function cannot_list_all_roles_users_with_user_without_permissions()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,['roles-users']);
        RoleUser::factory()->count(5)->create();
        $response = $this->getJson(route('api.users.roles.index'));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function cannot_list_all_roles_users_without_authentication()
    {
        RoleUser::factory()->count(5)->create();
        $response = $this->getJson(route('api.users.roles.index'));
        $response->assertUnauthorized();
    }
}
