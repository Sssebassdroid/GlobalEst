<?php

namespace Database\Factories;

use App\Models\Occurrence;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;

class OccurrenceFactory extends Factory
{
    protected $model = Occurrence::class;

    public function definition(): array
    {
        $startTime = fake()->dateTime();

        $endTime = (clone $startTime)->modify('+' . rand(1, 4) . ' hours');

        return [
            'date' => fake()->dateTimeBetween('now', '+6 months')->format('Y-m-d'),

            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),

            'capacity' => fake()->numberBetween(10, 30),
            'tour_id' => Tour::inRandomOrder()->first()?->id ?? Tour::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
