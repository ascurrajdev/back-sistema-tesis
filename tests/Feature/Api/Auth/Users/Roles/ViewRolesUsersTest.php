<?php

namespace Tests\Feature\Api\Auth\Users\Roles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\RoleUser;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ViewRolesUsersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_view_a_role_user_with_user_with_permission()
    {
        RoleUser::factory()->count(10)->create();
        $user = User::factory()->create();
        $role = RoleUser::first();
        Sanctum::actingAs($user,['*']);
        $response = $this->getJson(route('api.users.roles.view',$role));
        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function cannot_view_a_role_user_with_user_without_permission()
    {
        RoleUser::factory()->count(10)->create();
        $user = User::factory()->create();
        $role = RoleUser::first();
        Sanctum::actingAs($user,['roles']);
        $response = $this->getJson(route('api.users.roles.view',$role));
        $response->assertForbidden();
    }
}
