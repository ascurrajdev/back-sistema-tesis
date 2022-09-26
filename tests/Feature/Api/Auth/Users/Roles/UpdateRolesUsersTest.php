<?php

namespace Tests\Feature\Api\Auth\Users\Roles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\RoleUser;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class UpdateRolesUsersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_update_a_role_user_with_user_with_permissions()
    {
        RoleUser::factory()->count(10)->create();
        $role = RoleUser::first();
        Sanctum::actingAs(User::factory()->create(),['*']);
        $response = $this->putJson(route('api.users.roles.update',$role),[
            'name' => 'Permiso 1'
        ]);
        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function cannot_update_a_role_user_with_user_without_permissions()
    {
        RoleUser::factory()->count(10)->create();
        $role = RoleUser::first();
        Sanctum::actingAs(User::factory()->create(),['any']);
        $response = $this->putJson(route('api.users.roles.update',$role),[
            'name' => 'Permiso 1'
        ]);
        $response->assertForbidden();
    }
}
