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
        $query = Tour::latestFeatured()->with(['agency']);

        $query = match ($orderBy) {
            TourOrderBy::PRICE_ASC  => $query->orderBy('price', 'asc'),
            TourOrderBy::PRICE_DESC => $query->orderBy('price', 'desc'),
            TourOrderBy::LATEST     => $query->latest(),
        };

        return $query->take($limit)->get();
    }
}
