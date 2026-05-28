<?php

namespace Database\Factories;
use App\Models\Agency;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgencyFactory extends Factory
{
    protected $model = Agency::class;

    public function definition(): array
    {
        return [
            'agency_name' => fake()->company(),
            'user_id' => User::inRandomOrder()->first()?->id_user ?? User::factory(),
        ];
    }
}
