<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\PlaceAvailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlacesAvailableController extends Controller
{
    public function display()
    {
        return view('add_place');
    }

    /**
     * Recibe la selección y la envía a la siguiente fase.
     * Ya NO usa session. El frontend debe manejar el paso de datos.
     */
    public function processSelection(Request $request)
    {
        try {
            $puntos = json_decode($request->input('puntos_json'), true);

            if (!$puntos || count($puntos) === 0) {
                Log::warning('Intento de envío de itinerario vacío.', ['user_id' => auth()->id()]);
                return response()->json(['status' => 'error', 'message' => 'No hay puntos seleccionados.'], 400);
            }

            Log::info('Itinerario validado en cliente listo para persistencia.', ['puntos_count' => count($puntos)]);

            return redirect('/create-tour')->with('success', 'Lugares procesados correctamente!');


        } catch (\Exception $e) {
            Log::error('Fallo al procesar selección de lugares: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Error al procesar los datos.'], 500);
        }
    }

    /**
     * Método estático de utilidad para persistir el itinerario.
     * Centralizamos aquí la lógica para evitar duplicidad en TourController.
     */
    public static function persistItinerary(int $tourId, array $puntos): void
{
    foreach ($puntos as $index => $punto) {
        $cityId = City::resolveUbication($punto);

        $lugarDB = PlaceAvailable::updateOrCreate(
            ['osm_id' => $punto['osm_id']], 
            [
                'name'         => $punto['name'],
                'display_name' => $punto['display_name'],
                'latitude'     => $punto['lat'],
                'longitude'    => $punto['long'],
                'osm_type'     => $punto['osm_type'],
                'city_id'      => $cityId // Naming correcto de la FK
            ]
        );

        DB::table('place_tour')->insert([
            'tour_id'        => $tourId,
            'place_id'       => $lugarDB->id_place,
            'order_position' => $index + 1,
            'created_at'     => now(),
        ]);
    }
}
}