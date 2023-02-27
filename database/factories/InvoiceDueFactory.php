<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Currency;
use App\Models\InvoiceDue;
use App\Models\Agency;
use App\Models\Reservation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceDue>
 */
class InvoiceDueFactory extends Factory
{
    protected $model = InvoiceDue::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'number_due' => 1,
            'amount' => 10000,
            'currency_id' => Currency::factory(),
            'agency_id' => Agency::factory(),
            'expiration_date' => now()->addDays(7),
            'reservation_id' => Reservation::factory(),
        ];
    }
}
