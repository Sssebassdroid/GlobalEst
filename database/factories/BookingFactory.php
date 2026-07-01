<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'date' => fake()->dateTimeThisYear(),
            'total' => fake()->randomFloat(2, 15, 1500),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'created_at' => fake()->dateTimeThisYear(),
            'updated_at' => fake()->dateTimeThisYear(),
        ];
    }
}
