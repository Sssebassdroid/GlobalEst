<?php

namespace Database\Factories;

use App\Models\CategoryTour;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryTourFactory extends Factory
{
    protected $model = CategoryTour::class;

    public function definition(): array
    {
        return [
            'tour_id' => $this->faker->randomNumber(),
            'category_id' => $this->faker->randomNumber(),
        ];
    }
}
