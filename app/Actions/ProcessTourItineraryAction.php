<?php

namespace App\Actions;

use App\Models\Tour;
use App\Models\Place;
use Illuminate\Support\Facades\Log;

class ProcessTourItineraryAction
{
    /**
     * Procesa los puntos geográficos y los sincroniza con el tour.
     */
    public function execute(Tour $tour, array $points): void
    {
        if (empty($points)) {
            Log::warning("No se recibieron puntos de itinerario para el tour {$tour->id}");
            return;
        }

        $placeIds = [];

        foreach ($points as $point) {

            $place = Place::firstOrCreate(
                ['osm_id' => $point['osm_id']],
                [
                    'name'         => $point['name'],
                    'display_name' => $point['display_name'],
                    'lat'     => $point['lat'],
                    'lon'    => $point['lon'],
                    'osm_type'     => $point['osm_type'],
                    'osm_id'     => $point['osm_id'],
                    'importance' => $point['importance'],
                ]
            );

            $placeIds[] = $place->id;
        }

        $tour->places()->sync($placeIds);

        Log::info("Itinerario sincronizado para el tour {$tour->id}", ['place_ids' => $placeIds]);
    }
}
