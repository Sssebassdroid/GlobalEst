<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Place;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaceFactory extends Factory
{
    protected $model = Place::class;

    public function definition(): array
    {
        return [
            'name' => fake()->streetName(),
            'display_name' => fake()->address(),
            'address_type' => fake()->randomElement(['historic', 'tourism', 'monument', 'attraction']),
            'lat' => fake()->latitude(),
            'lon' => fake()->longitude(),
            'osm_id' => fake()->optional()->numerify('#########'),
            'osm_type' => fake()->optional()->randomElement(['node', 'way', 'relation']),
            'state' => fake()->optional()->state(),
            'importance' => fake()->optional()->randomFloat(2, 0, 1),
            'city_id' => City::inRandomOrder()->first()?->id ?? City::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
