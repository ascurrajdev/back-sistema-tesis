<?php

namespace Tests\Feature\Api\Auth\Users\Payments;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Payment;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeletePaymentsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_delete_a_payment_with_a_user_with_permissions()
    {
        $payment = Payment::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user,['payments-delete']);
        $response = $this->deleteJson(route('api.users.payments.delete',$payment));
        $response->assertSuccessful();
        $this->assertSoftDeleted('payments',[
            'id' => $payment->id,
            'name' => $payment->name,
        ]);
    }

    /**
     * @test
     */
    public function cannot_delete_a_payment_with_a_user_without_permissions()
    {
        $payment = Payment::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user,['payments']);
        $response = $this->deleteJson(route('api.users.payments.delete',$payment));
        $response->assertForbidden();
    }
}
