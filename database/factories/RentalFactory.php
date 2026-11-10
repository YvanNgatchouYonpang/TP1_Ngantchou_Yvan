<?php

namespace Database\Factories;

use App\Models\Rental;
use App\Models\User;
use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rental>
 */
class RentalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-6 months', 'now');

        $endDate = (clone $startDate)->modify(
            '+' . fake()->numberBetween(1, 14) . ' days'
        );

        return [
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
            'totalPrice' => fake()->randomFloat(2, 10, 500),
            'userId' => User::inRandomOrder()->first()->id,
            'equipmentId' => Equipment::inRandomOrder()->first()->id,
        ];
    }
}
