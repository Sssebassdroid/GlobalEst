<?php

namespace Database\Factories;
use App\Models\Tour;
use App\Models\Agency;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourFactory extends Factory
{
    protected $model = Tour::class;

    public function definition(): array
    {
        return [
            'tour_name' => fake()->sentence(3),
            'tour_price' => fake()->randomFloat(2, 10, 500),
            'description' => fake()->optional()->paragraph(),
            'estimated_duration' => fake()->time('H:i:s'),
            'image' => fake()->optional()->imageUrl(),
            'agency_id' => Agency::inRandomOrder()->first()?->id_agency ?? Agency::factory(),
        ];
    }
}