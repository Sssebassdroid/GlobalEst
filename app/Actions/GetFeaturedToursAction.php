<?php

namespace App\Actions;

use App\Models\Tour;
use App\Enums\TourOrderBy;
use Illuminate\Database\Eloquent\Collection;

class GetFeaturedToursAction
{
    /**
     * Obtiene los tours destacados configurando el límite y el criterio de ordenamiento.
     * * @param int $limit Cantidad de registros a recuperar (Por defecto 6)
     * @param TourOrderBy $orderBy Estrategia de ordenación respaldada por Enum (Por defecto LATEST)
     * @return Collection
     */
    public function execute(int $limit = 6, TourOrderBy $orderBy = TourOrderBy::LATEST): Collection
    {
        // 1. Iniciamos la consulta base con la relación cargada (Eager Loading)
        $query = Tour::latestFeatured()->with(['agency']);

        // 2. Aplicamos la lógica de ordenamiento según el Enum mapeado
        $query = match ($orderBy) {
            TourOrderBy::PRICE_ASC  => $query->orderBy('tour_price', 'asc'),
            TourOrderBy::PRICE_DESC => $query->orderBy('tour_price', 'desc'),
            TourOrderBy::LATEST     => $query->latest(), // O la lógica predeterminada de tu Scope
        };

        // 3. Limitamos los resultados y ejecutamos la consulta
        return $query->take($limit)->get();
    }
}
