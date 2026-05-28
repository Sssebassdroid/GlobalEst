<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'order_date' => fake()->dateTimeThisYear(),
            'total_amount' => fake()->randomFloat(2, 15, 1500),
            'user_id' => User::inRandomOrder()->first()?->id_user ?? User::factory(),
        ];
    }
}