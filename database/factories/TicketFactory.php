<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Occurrence;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        $occurrence = Occurrence::inRandomOrder()->first() ?? Occurrence::factory()->create();
        $tour = $occurrence->tour;

        $quantity = fake()->numberBetween(1, 5);

        $tourPrice = $tour?->price ?? 25.00;
        $subtotal = $quantity * $tourPrice;

        return [
            'quantity' => $quantity,
            'subtotal' => $subtotal,

            'booking_id' => Booking::inRandomOrder()->first()?->id ?? Booking::factory(),
            'occurrence_id' => $occurrence->id,

            'created_at' => now(),
        ];
    }
}
