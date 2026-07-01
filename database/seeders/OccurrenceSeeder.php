<?php

namespace Database\Seeders;

use App\Models\Occurrence;
use Illuminate\Database\Seeder;

class OccurrenceSeeder extends Seeder
{
    public function run(): void
    {
        Occurrence::factory()->count(10)->create();
    }
}
