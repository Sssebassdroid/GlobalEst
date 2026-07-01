<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->optional(0.7)->sentence(10),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'tour_id' => Tour::inRandomOrder()->first()?->id ?? Tour::factory(),
            'created_at' => now(),
        ];
    }
}
