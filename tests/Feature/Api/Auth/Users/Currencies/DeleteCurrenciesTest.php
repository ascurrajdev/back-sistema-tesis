<?php

namespace Tests\Feature\Api\Auth\Users\Currencies;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteCurrenciesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_delete_a_currency_with_a_user_with_credentials()
    {
        $currency = Currency::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user,['currencies-delete']);
        $response = $this->deleteJson(route('api.users.currencies.delete',$currency));
        $response->assertStatus(200);
        $this->assertSoftDeleted('currencies',[
            'id' => $currency->id,
            'name' => $currency->name,
        ]);
    }

    /**
     * @test
     */
    public function cannot_delete_a_currency_with_a_user_without_credentials()
    {
        $currency = Currency::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user,['currencies']);
        $response = $this->deleteJson(route('api.users.currencies.delete',$currency));
        $response->assertForbidden();
        $this->assertDatabaseCount('currencies',1);
    }
}
