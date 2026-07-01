<?php
namespace Database\Seeders;

use App\Models\Continent;
use Illuminate\Database\Seeder;

class ContinentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $continents = [
            ['name' => 'Europa', 'code' => 'EU'],
            ['name' => 'Asia', 'code' => 'AS'],
            ['name' => 'Norteamérica', 'code' => 'NA'],
            ['name' => 'Sudamérica', 'code' => 'SA'],
            ['name' => 'Oceanía', 'code' => 'OC'],
            ['name' => 'África', 'code' => 'AF'],
        ];

        foreach ($continents as $continent) {
            Continent::factory()->create($continent);
        }
    }
}
