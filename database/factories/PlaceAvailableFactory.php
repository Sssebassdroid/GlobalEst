<?php

namespace Database\Factories;
use App\Models\Place;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaceAvailableFactory extends Factory
{
    protected $model = Place::class;

    public function definition(): array
    {
        return [
            'name' => fake()->streetName(),
            'display_name' => fake()->address(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'importance' => fake()->optional()->randomFloat(2, 0, 1),
            'osm_id' => fake()->optional()->randomNumber(8),
            'osm_type' => fake()->optional()->randomElement(['node', 'way', 'relation']),
            'city_id' => City::inRandomOrder()->first()?->id_city ?? City::factory(),
        ];
    }
}
