<?php

namespace Database\Factories;
use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    protected $model = City::class;

    public function definition(): array
    {
        return [
            'name' => fake()->city(),
            'country_id' => Country::inRandomOrder()->first()?->id_country ?? Country::factory(),
        ];
    }
}