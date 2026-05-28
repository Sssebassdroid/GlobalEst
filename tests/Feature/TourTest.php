<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Tour;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TourTest extends TestCase
{
    use RefreshDatabase;

    public function test_lectura_tours()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $tour = Tour::first();

        $this->assertNotNull($tour);
        $this->assertDatabaseHas('tour', ['id_tour' => $tour->id_tour]);
    }
}