<?php

namespace Tests\Feature\Api\Auth\Users\Products;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Models\Currency;
use Tests\TestCase;

class StoreProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_store_a_product_with_user_with_permissions()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ["products-store"]
        );
        $currency = Currency::factory()->create();
        $response = $this->postJson(route('api.users.products.store'),[
            'name' => 'Hotel Fachero',
            'amount' => 1000000,
            'currency_id' => $currency->id,
            'is_lodging' => 1,
            'active_for_reservation' => 1,
            'capacity_for_day_max' => 10,
            'capacity_for_day_min' => 1,
        ]);
        $response->assertSuccessful();
    }


    /**
     * @test
     */
    public function cannot_store_a_product_with_user_without_permissions(){
        Sanctum::actingAs(
            User::factory()->create(),
            ["products"]
        );
        $currency = Currency::factory()->create();
        $response = $this->postJson(route('api.users.products.store'),[
            'name' => 'Hotel Fachero',
            'amount' => 1000000,
            'currency_id' => $currency->id,
            'is_lodging' => 1,
            'active_for_reservation' => 1,
            'capacity_for_day_max' => 10,
            'capacity_for_day_min' => 1,
        ]);
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function cannot_store_a_product_without_user(){
        $currency = Currency::factory()->create();
        $response = $this->postJson(route('api.users.products.store'),[
            'name' => 'Hotel Fachero',
            'amount' => 1000000,
            'currency_id' => $currency->id,
            'is_lodging' => 1,
            'active_for_reservation' => 1,
            'capacity_for_day_max' => 10,
            'capacity_for_day_min' => 1,
        ]);
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function cannot_store_product_without_a_name(){
        Sanctum::actingAs(
            User::factory()->create(),
            ["products-store"]
        );
        $currency = Currency::factory()->create();
        $response = $this->postJson(route('api.users.products.store'),[
            'amount' => 1000000,
            'currency_id' => $currency->id,
            'is_lodging' => 1,
            'active_for_reservation' => 1,
            'capacity_for_day_max' => 10,
            'capacity_for_day_min' => 1,
        ]);
        $response->assertJsonValidationErrors('name');
    }

    /**
     * @test
     */
    public function cannot_store_product_without_amount(){
        Sanctum::actingAs(
            User::factory()->create(),
            ["products-store"]
        );
        $currency = Currency::factory()->create();
        $response = $this->postJson(route('api.users.products.store'),[
            'name' => 'Hotel Fachero',
            'currency_id' => $currency->id,
            'is_lodging' => 1,
            'active_for_reservation' => 1,
            'capacity_for_day_max' => 10,
            'capacity_for_day_min' => 1,
        ]);
        $response->assertJsonValidationErrors('amount');
    }
}
