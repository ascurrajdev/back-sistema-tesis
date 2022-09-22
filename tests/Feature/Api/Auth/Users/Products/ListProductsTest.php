<?php

namespace Tests\Feature\Api\Auth\Users\Products;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Tests\TestCase;

class ListProductsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_list_all_products_with_user_with_permissions()
    {
        Sanctum::actingAs(User::factory()->create(),['products-index']);
        $response = $this->getJson(route('api.users.products.index'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function cannot_list_products_with_user_without_permissions()
    {
        Sanctum::actingAs(User::factory()->create(),['product']);
        $response = $this->getJson(route('api.users.products.index'));
        $response->assertForbidden();
    }
}
