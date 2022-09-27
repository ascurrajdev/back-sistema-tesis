<?php

namespace Tests\Feature\Api\Auth\Users;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ViewUserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_view_a_users_with_user_with_permissions()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,['*']);
        $response = $this->getJson(route('api.users.view',$user));
        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function cannot_view_a_users_with_user_without_permissions()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,['any']);
        $response = $this->getJson(route('api.users.view',$user));
        $response->assertForbidden();
    }
}
