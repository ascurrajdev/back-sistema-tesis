<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\ReservationLimit;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReservationLimit>
 */
class ReservationLimitFactory extends Factory
{
    protected $model = ReservationLimit::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'date' => fake()->date(),
            'capacity_min' => fake()->numberBetween(0,10),
            'capacity_max' => fake()->numberBetween(90,130),
            'available' => fake()->numberBetween(90,130),
        ];
    }
}
