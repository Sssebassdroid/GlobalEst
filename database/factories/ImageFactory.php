<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    /**
     * Define el estado por defecto del modelo.
     */
    public function definition(): array
    {
        return [
            'url' => $this->faker->imageUrl(800, 600, 'travel'),

            'imageable_type' => 'tour',
            'imageable_id' => 1,

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function forTour(int $tourId): self
    {
        return $this->state(fn (array $attributes) => [
            'imageable_type' => 'tour',
            'imageable_id' => $tourId,
        ]);
    }

    public function forPlace(int $placeId): self
    {
        return $this->state(fn (array $attributes) => [
            'imageable_type' => 'place',
            'imageable_id' => $placeId,
        ]);
    }
}
