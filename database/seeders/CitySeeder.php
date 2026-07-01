<?php
namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = Country::all()->keyBy('code');

        $cityTemplates = [
            // Europa
            ['name' => 'Madrid', 'code' => 'MAD', 'country' => 'ESP'],
            ['name' => 'Barcelona', 'code' => 'BCN', 'country' => 'ESP'],
            ['name' => 'Roma', 'code' => 'ROM', 'country' => 'ITA'],
            ['name' => 'Perugia', 'code' => 'PEG', 'country' => 'ITA'],

            // Asia
            ['name' => 'Tokio', 'code' => 'TYO', 'country' => 'JPN'],
            ['name' => 'Kioto', 'code' => 'UKY', 'country' => 'JPN'],
            ['name' => 'Pekín', 'code' => 'BJS', 'country' => 'CHN'],
            ['name' => 'Shanghái', 'code' => 'SHA', 'country' => 'CHN'],

            // Norteamérica
            ['name' => 'Ciudad de México', 'code' => 'MEX', 'country' => 'MEX'],
            ['name' => 'Guadalajara', 'code' => 'GDL', 'country' => 'MEX'],
            ['name' => 'Toronto', 'code' => 'YTO', 'country' => 'CAN'],
            ['name' => 'Vancouver', 'code' => 'YVR', 'country' => 'CAN'],

            // Sudamérica
            ['name' => 'Lima', 'code' => 'LIM', 'country' => 'PER'],
            ['name' => 'Cusco', 'code' => 'CUZ', 'country' => 'PER'],
            ['name' => 'La Paz', 'code' => 'LPB', 'country' => 'BOL'],
            ['name' => 'Sucre', 'code' => 'SRE', 'country' => 'BOL'],

            // Oceanía
            ['name' => 'Sídney', 'code' => 'SYD', 'country' => 'AUS'],
            ['name' => 'Melbourne', 'code' => 'MEL', 'country' => 'AUS'],
            ['name' => 'Auckland', 'code' => 'AKL', 'country' => 'NZL'],
            ['name' => 'Wellington', 'code' => 'WLG', 'country' => 'NZL'],

            ['name' => 'El Cairo', 'code' => 'CAI', 'country' => 'EGY'],
            ['name' => 'Alejandría', 'code' => 'ALY', 'country' => 'EGY'],
            ['name' => 'Ciudad del Cabo', 'code' => 'CPT', 'country' => 'ZAF'],
            ['name' => 'Johannesburgo', 'code' => 'JNB', 'country' => 'ZAF'],
        ];

        foreach ($cityTemplates as $template) {
            $targetCountry = $countries->get($template['country']);

            if ($targetCountry) {
                City::factory()->create([
                    'name' => $template['name'],
                    'code' => $template['code'],
                    'country_id' => $targetCountry->id,
                ]);
            }
        }
    }
}
