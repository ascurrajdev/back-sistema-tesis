<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Currency;
use App\Models\Client;
use App\Models\Agency;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Collection>
 */
class CollectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'total_amount' => 1000,
            'currency_id' => Currency::factory(),
            'client_id' => Client::factory(),
            'agency_id' => Agency::factory(),
        ];
    }
}
