<?php

namespace Database\Seeders;

use App\Models\Place;
use App\Models\Image;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $places = Place::factory()->count(30)->create();

        foreach ($places as $place) {
            Image::factory()
                ->count(rand(1, 3))
                ->forPlace($place->id) // Vincula el alias 'place' y el ID dinámicamente
                ->create();
        }
    }
}
