<?php

namespace Tests\Feature\Api\Auth\Users\Products;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ViewProductsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function view_a_product_with_user_with_permissions()
    {
        $product = Product::factory()->create();
        Sanctum::actingAs(User::factory()->create(),['products-view']);
        $response = $this->getJson(route('api.users.products.view',$product));
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function cannot_view_a_product_with_user_without_permissions()
    {
        $product = Product::factory()->create();
        Sanctum::actingAs(User::factory()->create(),['products']);
        $response = $this->getJson(route('api.users.products.view',$product));
        $response->assertForbidden();
    }
}
