<?php

namespace App\DTOs;

use App\Http\Requests\StoreTourRequest;

readonly class TourDTO
{
    /**
     * Constructor del DTO empleando propiedades promocionadas de PHP 8.
     *
     * @param string $name Nombre del tour.
     * @param float $price Precio formateado como flotante.
     * @param string $description Descripción del destino.
     * @param string $estimatedDuration Duración estimada en formato 'H:i:s'.
     * @param array $categories Nombres de las categorías a asociar.
     * @param array $points Listado de coordenadas geográficas decodificadas.
     */
    public function __construct(
        public string $name,
        public float $price,
        public string $description,
        public string $estimatedDuration,
        public array $categories,
        public array $points
    ) {}

    /**
     * Método estático (Fábrica) para mapear y transformar
     * el Request HTTP validado hacia una instancia limpia del DTO.
     *
     * @param StoreTourRequest $request
     * @return self
     */
    public static function fromRequest(StoreTourRequest $request): self
    {
        // 1. Decodificar el JSON de categorías entrantes de forma segura
        $categoriesJson = $request->validated('categories_data');
        $categoriesArray = json_decode($categoriesJson, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($categoriesArray)) {
            $categoriesArray = [];
        }

        // 2. Decodificar el JSON del itinerario temporal (puntos del mapa)
        $pointsJson = $request->validated('session_itinerary');
        $pointsArray = json_decode($pointsJson, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($pointsArray)) {
            $pointsArray = [];
        }

        // 3. Formatear la duración estimada de forma consistente si es necesario
        $duration = $request->validated('estimated_duration');
        if (!empty($duration) && strlen($duration) === 5) { // Si viene como 'H:i' (ej: '02:30')
            $duration .= ':00'; // Lo convertimos a '02:30:00' para que coincida con el tipo TIME de la BD
        }

        // Retornamos la instancia construida y tipada
        return new self(
            name: $request->validated('tour_name'),
            price: (float) $request->validated('tour_price'),
            description: $request->validated('description'),
            estimatedDuration: $duration ?? '00:00:00',
            categories: $categoriesArray,
            points: $pointsArray
        );
    }
}
