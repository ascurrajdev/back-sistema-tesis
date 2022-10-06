<?php

namespace Tests\Feature\Api\Auth\Users\Currencies;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Currency;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ViewCurrenciesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_view_currencies_with_a_user_with_credentials()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->create();
        Sanctum::actingAs($user,['currencies-view']);
        $response = $this->getJson(route('api.users.currencies.view',$currency));
        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function cannot_view_currencies_with_a_user_without_credentials()
    {
        $user = User::factory()->create();
        $currency = Currency::factory()->create();
        Sanctum::actingAs($user,['currencies']);
        $response = $this->getJson(route('api.users.currencies.view',$currency));
        $response->assertForbidden();
    }
}
