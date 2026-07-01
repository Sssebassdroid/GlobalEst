<?php

namespace Database\Factories;

use App\Models\Continent;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    protected $model = Country::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'code' => $this->faker->unique()->regexify('[A-Z]{3}'),
            'continent_id' => Continent::inRandomOrder()->first()?->id ?? Continent::factory(),
        ];
    }
}
