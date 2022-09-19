<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Agency;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agency>
 */
class AgencyFactory extends Factory
{

    protected $model = Agency::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'city' => fake()->city(),
            'address' => fake()->address(),
            'neighborhood' => fake()->city(),
            "user_id" => User::factory(),
            'active_for_reservations_online' => true,
        ];
    }
}
