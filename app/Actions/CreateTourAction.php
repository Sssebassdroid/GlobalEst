<?php

namespace App\Actions;

use App\Models\Tour;
use App\DTOs\TourDTO;
use App\Models\Category;
use App\Http\Controllers\PlaceController;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CreateTourAction
{
    /**
     * Ejecuta la lógica de negocio para registrar un Tour completo.
     *
     * @param TourDTO $tourData Objeto de transporte de datos tipado.
     * @param int $agencyId Identificador de la agencia que publica el tour.
     * @param string $imagePath Ruta de almacenamiento de la imagen en disco.
     * @return Tour
     * @throws Exception
     * @throws Throwable
     */
    public function execute(TourDTO $tourData, int $agencyId, string $imagePath): Tour
    {
        return DB::transaction(function () use ($tourData, $agencyId, $imagePath) {

            Log::info('Action: Iniciando inserción de datos del tour en la BD', [
                'tour_name' => $tourData->name,
                'agency_id' => $agencyId
            ]);

            // 1. Crear el registro principal del Tour
            $tour = Tour::create([
                'agency'             => $agencyId, // Llave foránea según tu base de datos
                'name'          => $tourData->name,
                'price'         => $tourData->price,
                'description'        => $tourData->description,
                'duration' => $tourData->duration,
                'image'              => $imagePath,
            ]);

            Log::info('Action: Procesando y persistiendo itinerario de puntos geográficos');

            PlaceController::persistItinerary($tour->id, $tourData->points);

            if (!empty($tourData->categories)) {
                Log::info('Action: Sincronizando categorías asociadas al tour', [
                    'categories' => $tourData->categories
                ]);

                $categoryIds = [];

                foreach ($tourData->categories as $categoryName) {
                    $category = Category::firstOrCreate([
                        'name' => trim($categoryName)
                    ]);
                    $categoryIds[] = $category->id;
                }

                $tour->categories()->sync($categoryIds);
            }

            Log::info('Action: Transacción completada con éxito en la base de datos', [
                'tour_id' => $tour->id_tour
            ]);

            return $tour;
        });
    }
}
