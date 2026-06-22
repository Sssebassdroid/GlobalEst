<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\PlaceAvailable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlacesAvailableController extends Controller
{
    public function display()
    {
        return view('add_place');
    }

    public function processSelection(Request $request)
    {
        try {
            $points = json_decode($request->input('temporal-itinerary'), true);

            if (!$points || count($points) === 0) {
                Log::warning('Intento de envío de itinerario vacío.', ['user_id' => auth()->id()]);
                return response()->json(['status' => 'error', 'message' => 'No hay points seleccionados.'], 400);
            }

            Log::info('Itinerario validado en cliente listo para persistencia.', ['puntos_count' => count($points)]);

            return redirect('/create-tour')->with('success', 'Lugares procesados correctamente!');


        } catch (Exception $e) {
            Log::error('Fallo al procesar selección de lugares: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Error al procesar los datos.'], 500);
        }
    }

public static function persistItinerary(int $tourId, array $points): void
{
    try {
        foreach ($points as $index => $point) {
            $cityId = City::resolveUbication($point);

            $placeDB = PlaceAvailable::updateOrCreate(
                ['osm_id' => $point['osm_id']],
                [
                    'name'         => $point['name'],
                    'display_name' => $point['display_name'],
                    'latitude'     => $point['lat'],
                    'longitude'    => $point['long'],
                    'osm_type'     => $point['osm_type'],
                    'city_id'      => $cityId
                ]
            );

            // Inserción en tabla pivote con naming de BD correcto
            DB::table('place_tour')->insert([
                'tour_id'        => $tourId,
                'place_id'       => $placeDB->id_place,
                'order_position' => $index + 1,
                'created_at'     => now(),
            ]);
        }
        Log::info("Itinerario persistido para Tour ID: $tourId");
    } catch (Exception $e) {
        Log::error('Fallo en persistencia de itinerario.', ['error' => $e->getMessage()]);
        throw $e;
    }
}
}
