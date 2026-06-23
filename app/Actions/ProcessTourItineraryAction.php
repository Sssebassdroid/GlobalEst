<?php

namespace App\Actions;

use App\Models\Tour;
use App\Models\PlaceAvailable;
use Illuminate\Support\Facades\Log;

class ProcessTourItineraryAction
{
    /**
     * Procesa los puntos geográficos y los sincroniza con el tour.
     */
    public function execute(Tour $tour, array $puntos): void
    {
        if (empty($puntos)) {
            Log::warning("No se recibieron puntos de itinerario para el tour {$tour->id}");
            return;
        }

        $placeIds = [];

        // 1. Iteramos sobre cada punto recibido en el DTO
        foreach ($puntos as $punto) {

            // Si el lugar ya existe (buscando por osm_id), lo recupera.
            // Si no existe, lo inserta en places_available con los datos extra.
            $place = PlaceAvailable::firstOrCreate(
                ['osm_id' => $punto['osm_id']], // Condición de búsqueda
                [
                    'name'         => $punto['name'],
                    'display_name' => $punto['display_name'],
                    'latitude'     => $punto['lat'],
                    'longitude'    => $punto['long'],
                    'osm_type'     => $punto['osm_type'],
                ] // Datos a insertar si no se encuentra
            );

            // Guardamos la llave primaria (id_place según tu esquema)
            $placeIds[] = $place->id_place;
        }

        // 2. Sincroniza la relación con la tabla pivote 'place_tour'
        // NOTA: Esto asume que tienes un método places() en el modelo Tour.
        $tour->places()->sync($placeIds);

        Log::info("Itinerario sincronizado para el tour {$tour->id_tour}", ['place_ids' => $placeIds]);
    }
}
