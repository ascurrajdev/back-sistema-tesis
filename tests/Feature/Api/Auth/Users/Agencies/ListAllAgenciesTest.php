<?php

namespace Tests\Feature\Api\Auth\Users\Agencies;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Agency;
use Laravel\Sanctum\Sanctum;

class ListAllAgenciesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_list_all_agencies_with_a_user_with_permissions()
    {
        Agency::factory()->count(10)->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user,['agencies-index']);
        $response = $this->getJson(route('api.users.agencies.index'));
        $response->assertSuccessful();
        $response->assertJsonCount(10,'data');
    }

    /**
     * @test
     */
    public function cannot_list_all_agencies_with_a_user_without_permissions()
    {
        Agency::factory()->count(10)->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user,['agencies']);
        $response = $this->getJson(route('api.users.agencies.index'));
        $response->assertForbidden();
    }
}
