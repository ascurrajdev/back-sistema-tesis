<?php

namespace Tests\Feature\Api\Auth\Clients\InvoiceDue;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\InvoiceDue;
use App\Models\Reservation;
use App\Models\Client;
use App\Models\ReservationDetail;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PaymentDueTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_get_link_payment_of_a_invoice_due_of_initial_payment_for_reservation()
    {
        $client = Client::factory()->create();
        Sanctum::actingAs($client,['*']);
        $reservation = Reservation::factory()->create();
        ReservationDetail::factory()->for($reservation)->create();
        $invoiceDue = InvoiceDue::factory()->for($reservation)->create([
            'is_initial_reservation_payment' => true,
        ]);
        $response = $this->getJson(route('api.clients.invoice_due.payment',$invoiceDue));
        $response->assertSuccessful();
    }
}
