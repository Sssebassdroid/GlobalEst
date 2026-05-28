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
        return [
            // Eventos programados entre hoy y dentro de 6 meses
            'date_occurrence' => fake()->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
            'start_hour' => fake()->time('H:i:s'),
            'maximum_person' => fake()->numberBetween(10, 30),
            'tour_id' => Tour::inRandomOrder()->first()?->id_tour ?? Tour::factory(),
        ];
    }
}