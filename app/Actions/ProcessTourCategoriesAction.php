<?php

namespace App\Actions;

use App\Models\Tour;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class ProcessTourCategoriesAction
{
    public function execute(Tour $tour, string $categoriesJson): void
    {
        $categoryNames = json_decode($categoriesJson, true);

        if (!is_array($categoryNames)) {
            Log::warning("JSON de categorías inválido para el tour {$tour->id_tour}");
            return;
        }

        $categoryIds = [];

        foreach ($categoryNames as $name) {
            $cleanName = trim($name);
            if (empty($cleanName)) continue;

            $category = Category::firstOrCreate(['name' => $cleanName]);

            $categoryIds[] = $category->id_category;
        }

        $tour->categories()->sync($categoryIds);

        Log::info("Categorías sincronizadas para el tour {$tour->id_tour}", ['ids' => $categoryIds]);
    }
}
