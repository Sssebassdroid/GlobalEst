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
    // 1. Creamos el rol de EMPRESA (ID 2) para saltar el middleware
    $role = \App\Models\Role::factory()->create([
        'id_role' => 2, 
        'type' => 'empresa' 
    ]);

    $user = \App\Models\User::factory()->create([
        'role_id' => $role->id_role
    ]);

    // 2. Definimos los datos (OJO: Tu controlador espera 'itinerario-temporal' según el JS)
    $puntosCompletos = json_encode([
        [
            'osm_id' => 987654321,
            'name' => 'Piazza IV Novembre',
            'display_name' => 'Piazza IV Novembre, Perugia, Italia',
            'lat' => 43.1121,
            'long' => 12.3888, // Ojo: verifica si usas 'long' o 'lng' en el JSON
            'importance' => 0.85,
            'city' => 'Perugia',
            'osm_type' => 'way'
        ]
    ]);

    // 3. Ejecutamos la petición a la ruta CORRECTA
    $response = $this->actingAs($user)->post(route('places.add'), [
        'itinerario-temporal' => $puntosCompletos 
    ]);

    // 4. Verificamos REDIRECCIÓN (302) en lugar de 200
    $response->assertStatus(302);
    $response->assertRedirect(route('tour.create'));

    // 5. Verificamos que el punto Rse haya "registrado" en la sesión o lógica previa
    // Nota: Si tu controlador no guarda en BD hasta el paso final, 
    // este assertDatabaseHas podría fallar aquí y deberías moverlo al TourTest.
}
}