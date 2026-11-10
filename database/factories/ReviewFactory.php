<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use App\Models\Rental;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->sentence(),
            'userId' => User::inRandomOrder()->first()->id,
            'rentalId' => Rental::inRandomOrder()->first()->id,
        ];
    }
}
