<?php

namespace Tests\Feature\Api\Auth\Users\Roles;

use App\Models\RoleUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Tests\TestCase;

class DeleteRolesUsersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_delete_a_role_user_with_user_with_permissions()
    {
        RoleUser::factory()->count(10)->create();
        $role = RoleUser::first();
        Sanctum::actingAs(User::factory()->create(),['*']);
        $response = $this->deleteJson(route('api.users.roles.delete',$role));
        $response->assertSuccessful();
        $this->assertSoftDeleted('role_users',[
            'id' => $role->id,
            'name' => $role->name
        ]);
    }

    /**
     * @test
     */
    public function cannot_delete_a_role_user_with_user_without_permissions()
    {
        RoleUser::factory()->count(10)->create();
        $role = RoleUser::first();
        Sanctum::actingAs(User::factory()->create(),['products']);
        $response = $this->deleteJson(route('api.users.roles.delete',$role));
        $response->assertForbidden();
    }
}
