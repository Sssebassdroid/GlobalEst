<?php

namespace App\Actions;

use App\Models\Agency;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class GetAgencyToursAction
{
    /**
     * Recupera todos los tours asociados a la agencia de un usuario.
     *
     * @param int $userId
     * @return Collection
     */
    public function execute(int $userId): Collection
    {
        $agency = Agency::where('user_id', $userId)->firstOrFail();

        $tours = Tour::where('agency_id', $agency->id)
            ->with('categories')
            ->get();

        Log::info('Carga de tours completada desde Action.', [
            'agency_id' => $agency->id,
            'count'     => $tours->count()
        ]);

        return $tours;
    }
}
