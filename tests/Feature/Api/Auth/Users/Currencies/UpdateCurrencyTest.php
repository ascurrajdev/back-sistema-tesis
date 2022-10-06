<?php

namespace Tests\Feature\Api\Auth\Users\Currencies;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Models\Currency;
use Tests\TestCase;

class UpdateCurrencyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_update_a_currency_with_a_user_with_permissions()
    {
        $currency = Currency::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user,['currencies-update']);
        $response = $this->putJson(route('api.users.currencies.update',$currency),[
            'name' => 'Guarani Paraguayo'
        ]);
        $response->assertSuccessful();
        $this->assertDatabaseHas('currencies',[
            'id' => $currency->id,
            'name' => 'Guarani Paraguayo'
        ]);
    }

    /**
     * @test
     */
    public function cannot_update_a_currency_with_a_user_without_permissions()
    {
        $currency = Currency::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user,['currencies']);
        $response = $this->putJson(route('api.users.currencies.update',$currency),[
            'name' => 'Guarani Paraguayo'
        ]);
        $response->assertForbidden();
        $this->assertDatabaseMissing('currencies',[
            'id' => $currency->id,
            'name' => 'Guarani Paraguayo'
        ]);
    }
}
