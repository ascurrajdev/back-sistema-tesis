<?php

namespace Tests\Feature\Api\Auth\Users\Currencies;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ListAllCurrenciesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_list_all_currencies_with_a_user_with_permissions()
    {
        $user = User::factory()->create();
        Currency::factory()->create();
        Sanctum::actingAs($user,['currencies-index']);
        $response = $this->getJson(route('api.users.currencies.index'));
        $response->assertSuccessful();
        $response->assertJsonCount(1,'data');
    }

    /**
     * @test
     */
    public function cannot_list_all_currencies_with_a_user_without_permissions()
    {
        $user = User::factory()->create();
        Currency::factory()->create();
        Sanctum::actingAs($user,['currencies']);
        $response = $this->getJson(route('api.users.currencies.index'));
        $response->assertForbidden();
    }
}
