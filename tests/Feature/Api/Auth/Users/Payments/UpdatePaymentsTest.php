<?php

namespace Tests\Feature\Api\Auth\Users\Payments;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Payment;
use Laravel\Sanctum\Sanctum;

class UpdatePaymentsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_update_a_payment_with_user_with_permissions()
    {
        $payment = Payment::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user,['payments-update']);
        $response = $this->putJson(route('api.users.payments.update',$payment),[
            'name' => 'Prueba update 1'
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('payments',[
            'id' => $payment->id,
            'name' => 'Prueba update 1'
        ]);
    }

    /**
     * @test
     */
    public function cannot_update_a_payment_with_user_without_permissions()
    {
        $payment = Payment::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user,['payments']);
        $response = $this->putJson(route('api.users.payments.update',$payment),[
            'name' => 'Prueba update 1'
        ]);
        $response->assertForbidden();
        $this->assertDatabaseMissing('payments',[
            'id' => $payment->id,
            'name' => 'Prueba update 1'
        ]);
    }
}
