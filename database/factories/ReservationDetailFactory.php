<?php

namespace Database\Factories;

use App\Models\ReservationDetail;
use App\Models\Reservation;
use App\Models\Currency;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReservationDetail>
 */
class ReservationDetailFactory extends Factory
{
    protected $model = ReservationDetail::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'quantity' => 1,
            'amount' => 10000,
            'discount' => 0,
            'currency_id' => Currency::factory(),
            'reservation_id' => Reservation::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
