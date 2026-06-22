<?php
namespace App\Actions;

use App\Models\{Continent, Country, City};

class ResolveLocationAction
{
    public function execute(array $data): City
    {
        $continent = Continent::firstOrCreate(['name' => 'Europa']);

        $country = Country::firstOrCreate(
            ['name' => $data['country_name'] ?? 'Desconocido'],
            ['continent_id' => $continent->id]
        );

        return City::firstOrCreate(
            ['name' => $data['city_name'] ?? 'Desconocida'],
            ['country_id' => $country->id]
        );
    }
}
