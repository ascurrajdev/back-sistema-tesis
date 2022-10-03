<?php

namespace Tests\Feature\Api\Auth\Users\Payments;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Payment;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ShowPaymentsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_show_a_payment_with_user_with_permissions()
    {
        $payment = Payment::factory()->create();
        Sanctum::actingAs(User::factory()->create(),['payments-view']);
        $response = $this->getJson(route('api.users.payments.view',$payment));
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function cannot_show_a_payment_with_user_without_permissions()
    {
        $payment = Payment::factory()->create();
        Sanctum::actingAs(User::factory()->create(),['payments']);
        $response = $this->getJson(route('api.users.payments.view',$payment));
        $response->assertForbidden();
    }
}
