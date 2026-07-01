<?php
namespace Database\Seeders;

use App\Models\Continent;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eu = Continent::where('code', 'EU')->first();
        $as = Continent::where('code', 'AS')->first();
        $na = Continent::where('code', 'NA')->first();
        $sa = Continent::where('code', 'SA')->first();
        $oc = Continent::where('code', 'OC')->first();
        $af = Continent::where('code', 'AF')->first();

        $countries = [
            ['name' => 'España', 'code' => 'ESP', 'continent_id' => $eu?->id],
            ['name' => 'Italia', 'code' => 'ITA', 'continent_id' => $eu?->id],

            ['name' => 'Japón', 'code' => 'JPN', 'continent_id' => $as?->id],
            ['name' => 'China', 'code' => 'CHN', 'continent_id' => $as?->id],

            ['name' => 'México', 'code' => 'MEX', 'continent_id' => $na?->id],
            ['name' => 'Canadá', 'code' => 'CAN', 'continent_id' => $na?->id],

            ['name' => 'Perú', 'code' => 'PER', 'continent_id' => $sa?->id],
            ['name' => 'Bolivia', 'code' => 'BOL', 'continent_id' => $sa?->id],

            ['name' => 'Australia', 'code' => 'AUS', 'continent_id' => $oc?->id],
            ['name' => 'Nueva Zelanda', 'code' => 'NZL', 'continent_id' => $oc?->id],

            ['name' => 'Egipto', 'code' => 'EGY', 'continent_id' => $af?->id],
            ['name' => 'Sudáfrica', 'code' => 'ZAF', 'continent_id' => $af?->id],
        ];

        foreach ($countries as $country) {
            if ($country['continent_id'] !== null) {
                Country::create($country);
            }
        }
    }
}
