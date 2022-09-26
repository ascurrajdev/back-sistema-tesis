<?php

namespace Tests\Feature\Api\Auth\Users\Products;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Models\Product;
use Tests\TestCase;

class UpdateProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_update_a_product_with_user_with_permissions()
    {
        $user = User::factory()->create();
        $product = Product::factory()
        ->for($user)
        ->create();
        Sanctum::actingAs(
            $user,
            ['products-update']
        );
        $response = $this->putJson(route('api.users.products.update',$product),[
            'name' => 'Hospedaje Fachero'
        ]);
        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function cannot_update_a_product_with_user_without_permissions()
    {
        $user = User::factory()->create();
        $product = Product::factory()
        ->for($user)
        ->create();
        Sanctum::actingAs(
            $user,
            ['products']
        );
        $response = $this->putJson(route('api.users.products.update',$product),[
            'name' => 'Hospedaje Fachero'
        ]);
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function cannot_update_a_product_without_user_authenticated()
    {
        $user = User::factory()->create();
        $product = Product::factory()
        ->for($user)
        ->create();
        $response = $this->putJson(route('api.users.products.update',$product),[
            'name' => 'Hospedaje Fachero'
        ]);
        $response->assertUnauthorized();
    }
}
