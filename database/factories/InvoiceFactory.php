<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Currency;
use App\Models\Agency;
use App\Models\Client;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'currency_id' => Currency::factory(),
            'total_amount' => fake()->numberBetween(120000),
            'total_discount' => 0,
            'operation_type' => 'credito',
            'expiration_date' => fake()->date(),
            'agency_id' => Agency::factory(),
            'client_id' => Client::factory()
        ];
    }
}
