<?php

namespace Tests\Feature\Api\Auth\Users;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_delete_a_user_with_user_with_permissions()
    {
        $user = User::factory()->create();
        User::factory()->count(10)->create();
        $userLast = User::get()->last();
        Sanctum::actingAs($user,['users-delete']);
        $response = $this->deleteJson(route('api.users.delete',$userLast));
        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function cannot_delete_the_same_user_with_current_authenticated()
    {
        $user = User::factory()->create();
        User::factory()->count(10)->create();
        Sanctum::actingAs($user,['users-delete']);
        $response = $this->deleteJson(route('api.users.delete',$user));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function cannot_delete_user_with_a_user_without_permissions()
    {
        $user = User::factory()->create();
        User::factory()->count(10)->create();
        Sanctum::actingAs($user,['any']);
        $response = $this->deleteJson(route('api.users.delete',$user));
        $response->assertForbidden();
    }
}
