<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Place;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaceAvailableTest extends TestCase
{
    use RefreshDatabase;

    public function test_verificacion_atributos_place()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $place = Place::where('name', 'Fontana Maggiore')->first();

        $this->assertNotNull($place);
        $this->assertEquals(43.1121, $place->latitude);
        $this->assertEquals(12.3888, $place->longitude);
    }
}
