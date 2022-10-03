<?php

namespace Tests\Feature\Api\Auth\Users\Payments;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreatePaymentsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_create_payment_with_a_user_with_permissions()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ['payments-store']
        );
        $response = $this->postJson(route('api.users.payments.store'),[
            'name' => 'Prueba'
        ]);
        $response->assertSuccessful();
        $this->assertDatabaseCount('payments',1);
    }

    /**
     * @test
     */
    public function cannot_create_payment_with_a_user_without_permissions()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ['payments']
        );
        $response = $this->postJson(route('api.users.payments.store'),[
            'name' => 'Prueba'
        ]);
        $response->assertForbidden();
        $this->assertDatabaseCount('payments',0);
    }
}
