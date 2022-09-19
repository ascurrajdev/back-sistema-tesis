<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\User;
use App\Models\Currency;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => "Pure de papa",
            'amount' => 10000,
            'amount_untaxed' => 10000,
            'currency_id' => Currency::factory(),
            'user_id' => User::factory(),
            'active_for_reservation' => true,
            'stockable' => false
        ];
    }
}
