<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            AgencySeeder::class,
            ContinentSeeder::class,
            CountrySeeder::class,
            CitySeeder::class,
            CategorySeeder::class,
            PlaceSeeder::class,
            TourSeeder::class,
            OccurrenceSeeder::class,
            BookingSeeder::class,
            TicketSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
