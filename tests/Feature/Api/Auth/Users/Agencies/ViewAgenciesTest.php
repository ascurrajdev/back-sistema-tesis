<?php

namespace Tests\Feature\Api\Auth\Users\Agencies;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Agency;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ViewAgenciesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_view_a_agency_with_a_user_with_permissions()
    {
        $agency = Agency::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user,['agencies-view']);
        $response = $this->getJson(route('api.users.agencies.view',$agency));
        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function cannot_view_a_agency_with_a_user_without_permissions()
    {
        $agency = Agency::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user,['agencies']);
        $response = $this->getJson(route('api.users.agencies.view',$agency));
        $response->assertForbidden();
    }
}
