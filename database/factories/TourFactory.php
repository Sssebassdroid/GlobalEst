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
            'name' => fake()->sentence(3, 4),
            'price' => fake()->randomFloat(2, 10, 500),
            'description' => fake()->paragraph(),
            'duration' => fake()->time(),
            'capacity' => fake()->numberBetween(5,50),
            'agency_id' => Agency::inRandomOrder()->first()?->id ?? Agency::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
