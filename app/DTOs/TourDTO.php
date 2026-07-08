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
     * @param string $duration
     * @param int $capacity
     * @param array $categories Nombres de las categorías a asociar.
     * @param array $points Listado de coordenadas geográficas decodificadas.
     */
    public function __construct(
        public string $name,
        public string $agency,
        public float $price,
        public string $description,
        public string $duration,
        public int $capacity,
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
        $categoriesJson = $request->validated('categories_data');
        $categoriesArray = json_decode($categoriesJson, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($categoriesArray)) {
            $categoriesArray = [];
        }

        $pointsJson = $request->validated('session_itinerary');
        $pointsArray = json_decode($pointsJson, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($pointsArray)) {
            $pointsArray = [];
        }

        $duration = $request->validated('estimated_duration');
        if (!empty($duration) && strlen($duration) === 5) { // Si viene como 'H:i' (ej: '02:30')
            $duration .= ':00'; // Lo convertimos a '02:30:00'
        }

        return new self(
            name: $request->validated('name'),
            agency: $request->validated('agency'),
            price: (float) $request->validated('price'),
            description: $request->validated('description'),
            duration: $duration ?? '00:00:00',
            capacity: $request->validated('capacity'),
            categories: $categoriesArray,
            points: $pointsArray
        );
    }
}
