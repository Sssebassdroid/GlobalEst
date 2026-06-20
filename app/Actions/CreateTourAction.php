<?php

namespace App\Actions;

use App\Models\Tour;
use App\DTOs\TourDTO;
use App\Models\Category;
use App\Http\Controllers\PlacesAvailableController;
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
        // Ejecutamos todo dentro de una transacción de Base de Datos para asegurar la atomicidad
        return DB::transaction(function () use ($tourData, $agencyId, $imagePath) {

            Log::info('Action: Iniciando inserción de datos del tour en la BD', [
                'tour_name' => $tourData->name,
                'agency_id' => $agencyId
            ]);

            // 1. Crear el registro principal del Tour
            $tour = Tour::create([
                'agency'             => $agencyId, // Llave foránea según tu base de datos
                'tour_name'          => $tourData->name,
                'tour_price'         => $tourData->price,
                'description'        => $tourData->description,
                'estimated_duration' => $tourData->estimatedDuration,
                'image'              => $imagePath,
            ]);

            // 2. Vincular los Lugares Disponibles (Itinerario / Puntos Geográficos)
            Log::info('Action: Procesando y persistiendo itinerario de puntos geográficos');

            // Reutilizamos e integramos la lógica de tu controlador de lugares pasándole el array decodificado
            // NOTA: Asegúrate de adaptar PlacesAvailableController si requiere el request HTTP completo o solo el array.
            PlacesAvailableController::persistItinerary($tour->id_tour, $tourData->points);

            // 3. Vincular las Categorías del Tour (Relación Many-to-Many)
            if (!empty($tourData->categories)) {
                Log::info('Action: Sincronizando categorías asociadas al tour', [
                    'categories' => $tourData->categories
                ]);

                $categoryIds = [];

                foreach ($tourData->categories as $categoryName) {
                    // Buscamos la categoría por nombre o la creamos si no existe
                    $category = Category::firstOrCreate([
                        'name' => trim($categoryName)
                    ]);
                    $categoryIds[] = $category->id_category;
                }

                // Sincronizamos en la tabla pivote 'category_tour'
                $tour->categories()->sync($categoryIds);
            }

            Log::info('Action: Transacción completada con éxito en la base de datos', [
                'tour_id' => $tour->id_tour
            ]);

            return $tour;
        });
    }
}
