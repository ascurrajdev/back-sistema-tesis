<?php

namespace Tests\Feature\Api\Auth\Users\Payments;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Payment;
use Laravel\Sanctum\Sanctum;

class ListPaymentsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_list_all_payments_with_a_user_with_permissions()
    {
        Payment::factory()->count(5)->create();
        Sanctum::actingAs(User::factory()->create(),['payments-index']);
        $response = $this->getJson(route('api.users.payments.index'));
        $response->assertSuccessful();
        $response->assertJsonCount(5,"data");
    }

    /**
     * @test
     */
    public function cannot_list_all_payments_with_a_user_without_permissions()
    {
        Payment::factory()->count(5)->create();
        Sanctum::actingAs(User::factory()->create(),['payments']);
        $response = $this->getJson(route('api.users.payments.index'));
        $response->assertForbidden();
    }
}
