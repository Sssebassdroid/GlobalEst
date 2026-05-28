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
            'rating' => fake()->numberBetween(1, 5), // Estrellas del 1 al 5
            'comment' => fake()->optional(0.7)->text(200), // 70% de probabilidad de tener comentario
            'user_id' => User::inRandomOrder()->first()?->id_user ?? User::factory(),
            'tour_id' => Tour::inRandomOrder()->first()?->id_tour ?? Tour::factory(),
        ];
    }
}