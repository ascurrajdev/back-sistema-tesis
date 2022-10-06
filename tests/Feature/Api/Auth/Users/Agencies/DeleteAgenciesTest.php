<?php

namespace Tests\Feature\Api\Auth\Users\Agencies;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Agency;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteAgenciesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_delete_a_agency_with_a_user_with_permissions()
    {
        Agency::factory()->count(10)->create();
        $agency = Agency::first();
        $user = User::factory()->create();
        Sanctum::actingAs($user,['agencies-delete']);
        $response = $this->deleteJson(route('api.users.agencies.delete',$agency));
        $response->assertSuccessful();
        $this->assertSoftDeleted('agencies',[
            'id' => $agency->id,
        ]);
    }

    /**
     * @test
     */
    public function cannot_delete_a_agency_with_a_user_without_permissions()
    {
        Agency::factory()->count(10)->create();
        $agency = Agency::first();
        $user = User::factory()->create();
        Sanctum::actingAs($user,['agencies']);
        $response = $this->deleteJson(route('api.users.agencies.delete',$agency));
        $response->assertForbidden();
        $this->assertNotSoftDeleted('agencies',[
            'id' => $agency->id,
        ]);
    }
}
