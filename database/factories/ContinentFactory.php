<?php

namespace Database\Factories;
use App\Models\Continent;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContinentFactory extends Factory
{
    protected $model = Continent::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
        ];
    }
}
