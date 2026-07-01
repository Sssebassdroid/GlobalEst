<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Histórico',
            'Gastronómico',
            'Aventura',
            'Naturaleza',
            'Cultural',
            'Religioso',
            'Nocturno',
            'Familiar'
        ];

        foreach ($categories as $category) {
            Category::factory()->create([
                'name' => $category,
            ]);
        }
    }
}
