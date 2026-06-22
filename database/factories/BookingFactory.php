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
            'order_date' => fake()->dateTimeThisYear(),
            'total_amount' => fake()->randomFloat(2, 15, 1500),
            'user_id' => User::inRandomOrder()->first()?->id_user ?? User::factory(),
        ];
    }
}
