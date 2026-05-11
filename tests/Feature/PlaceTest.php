<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlaceTest extends TestCase
{

use RefreshDatabase; 
   public function test_itinerario_guarda_todos_los_atributos_tecnicos()
{
    $user = \App\Models\User::factory()->create(['role' => 1]);
    
    $puntosCompletos = json_encode([
        [
            'id' => 123456,
            'name' => 'Piazza IV Novembre',
            'display_name' => 'Piazza IV Novembre, 06123 Perugia PG, Italia',
            'lat' => 43.1121,
            'lng' => 12.3888,
            'importance' => 0.85,
            'city' => 'Perugia',
            'osm_type' => 'way',
            'osm_id' => 987654321
        ]
    ]);

    $response = $this->actingAs($user)->post('/places/add', [
        'puntos_json' => $puntosCompletos,
        'tour_id' => 1
    ]);

    $response->assertStatus(200);
    
    $this->assertDatabaseHas('places_available', [
        'name' => 'Piazza IV Novembre',
        'latitude' => 43.1121,
        'longitude' => 12.3888,
        'importance' => 0.85,
        'city' => 'Perugia',
        'osm_id' => 987654321,
        'osm_type' => 'way'
    ]);
}
}
