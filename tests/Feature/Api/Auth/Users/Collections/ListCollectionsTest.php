<?php

namespace Tests\Feature\Api\Auth\Users\Collections;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ListCollectionsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_list_all_collections_with_user_with_ability()
    {
        Sanctum::actingAs(User::factory()->create(),[
            'collections-index'
        ]);
        $response = $this->getJson(route('api.users.collections.index'));
        $response->assertStatus(200);
        $response->dump();
    }
}
