<?php

namespace Tests\Feature\Api\Auth\Users\Currencies;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateCurrencyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_create_a_currency_with_a_user_with_credentials()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,['currencies-store']);
        $response = $this->postJson(route('api.users.currencies.store'),[
            'name' => 'Guaranies',
            'currency_format' => 'Gs',
            'decimals' => 0,
        ]);
        $response->assertSuccessful();
        $this->assertDatabaseCount('currencies',1);
    }

    /**
     * @test
     */
    public function cannot_create_a_currency_with_a_user_without_credentials()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,['currencies']);
        $response = $this->postJson(route('api.users.currencies.store'),[
            'name' => 'Guaranies',
            'currency_format' => 'Gs',
            'decimals' => 0,
        ]);
        $response->assertForbidden();
    }
}
