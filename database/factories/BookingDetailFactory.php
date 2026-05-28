<?php

namespace Database\Factories;

use App\Models\BookingDetail;
use App\Models\Order;
use App\Models\Occurrence;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingDetailFactory extends Factory
{
    protected $model = BookingDetail::class;

    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 5);
        $subtotal = fake()->randomFloat(2, 20, 200);

        return [
            'quantity' => $quantity,
            'subtotal' => $subtotal * $quantity, // Simulamos un cálculo lógico
            'order_id' => Order::inRandomOrder()->first()?->id_order ?? Order::factory(),
            'occurrence_id' => Occurrence::inRandomOrder()->first()?->id_occurrence ?? Occurrence::factory(),
        ];
    }
}