<?php

namespace Tests\Feature\Api\Auth\Users\Invoices;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Invoice;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ListInvoicesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function cannot_list_all_invoices_a_user_ghost()
    {
        $response = $this->getJson(route('api.users.invoices.index'));
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function can_list_all_invoices_a_user_authenticated_and_with_ability()
    {
        Invoice::factory()->count(5)->create();
        Sanctum::actingAs(User::factory()->create(),['invoices-index']);
        $response = $this->getJson(route('api.users.invoices.index'));
        $response->assertSuccessful();
        $response->assertJsonCount(5,'data');

    }
    /**
     * @test
     */
    public function cannot_list_all_invoices_a_user_authenticated_and_without_ability()
    {
        Sanctum::actingAs(User::factory()->create(),[]);
        $response = $this->getJson(route('api.users.invoices.index'));
        $response->assertForbidden();
    }
}
