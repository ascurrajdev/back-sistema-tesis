<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reservation;
use App\Models\Client;
use App\Models\Agency;
use App\Models\Currency;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    protected $mode = Reservation::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'client_id' => Client::factory(),
            'agency_id' => Agency::factory(),
            'currency_id' => Currency::factory(),
            'date_from' => now(),
            'date_to' => now(),
            'total_amount' => 100,
            'total_discount' => 0,
            'notes' => 'Ninguna',
            'active' => true,
        ];
    }
}
