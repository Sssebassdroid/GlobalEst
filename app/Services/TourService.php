<?php

namespace App\Services;

use App\Models\Tour;
use App\DTOs\TourDTO;
use App\Actions\CreateTourAction;
use App\Actions\ProcessTourCategoriesAction;
use App\Actions\ProcessTourItineraryAction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class TourService
{
    protected CreateTourAction $createTourAction;
    protected ProcessTourCategoriesAction $processCategoriesAction;
    protected ProcessTourItineraryAction $processItineraryAction;

    public function __construct(
        CreateTourAction $createTourAction,
        ProcessTourCategoriesAction $processCategoriesAction,
        ProcessTourItineraryAction $processItineraryAction
    ) {
        $this->createTourAction = $createTourAction;
        $this->processCategoriesAction = $processCategoriesAction;
        $this->processItineraryAction = $processItineraryAction;
    }

    /**
     * @throws Throwable
     */
    public function createFullTour(TourDTO $dto, int $agencyId, string $imagePath, string $categoriesJson): Tour
    {
        return DB::transaction(function () use ($dto, $agencyId, $imagePath, $categoriesJson) {

            $tour = $this->createTourAction->execute($dto, $agencyId, $imagePath);

            $this->processCategoriesAction->execute($tour, $categoriesJson);

            $this->processItineraryAction->execute($tour, $dto->points);

            Log::info("Tour {$tour->id_tour} creado exitosamente con todas sus relaciones.");

            return $tour;
        });
    }
}
