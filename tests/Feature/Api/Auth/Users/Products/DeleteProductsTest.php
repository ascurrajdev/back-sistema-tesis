<?php

namespace Tests\Feature\Api\Auth\Users\Products;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class DeleteProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_delete_a_products_with_users_with_permissions()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,['products-delete']);
        Product::factory()->count(10)->create();
        $product = Product::first();
        $response = $this->deleteJson(route('api.users.products.delete',$product));
        $response->assertSuccessful();
        $this->assertSoftDeleted("products",[
            'id' => $product->id,
            'name' => $product->name,
        ]);
        $this->assertDatabaseCount('products',10);
    }

    /**
     * @test
     */
    public function cannot_delete_a_products_with_users_without_permissions()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,['products']);
        Product::factory()->count(10)->create();
        $product = Product::first();
        $response = $this->deleteJson(route('api.users.products.delete',$product));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function cannot_delete_a_products_without_authorization()
    {
        Product::factory()->count(10)->create();
        $product = Product::first();
        $response = $this->deleteJson(route('api.users.products.delete',$product));
        $response->assertUnauthorized();
    }
}
