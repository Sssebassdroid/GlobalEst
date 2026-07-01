<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use App\Models\Place;
use App\Models\Tour;
use Illuminate\Database\Seeder;

class TourSeeder extends Seeder
{
    /**Database\Seeders\TourSeeder ............................................................................................................ RUNNING
     *
     * Illuminate\Database\QueryException
     *
     * SQLSTATE[42S22]: Column not found: 1054 Unknown column 'image' in 'field list' (Connection: mysql, Host: localhost, Port: 3306, Database: globalest, SQL: insert into `tour` (`name`, `price`, `description`, `duration`, `image`, `capacity`, `agency_id`, `created_at`, `updated_at`) values (Molestias rerum consectetur quia., 334.33, Dicta assumenda ratione facere quis at eveniet. Error doloremque pariatur repellat quam et ad., 11:10:28, https://via.placeholder.com/640x480.png/0011ee?text=aut, 49, 6, 2026-06-25 21:57:30, 2026-06-25 21:57:30))
     *
     * at vendor\laravel\framework\src\Illuminate\Database\Connection.php:843
     * 839▕             $exceptionType = ($isUniqueConstraintError = $this->isUniqueConstraintError($e))
     * 840▕                 ? UniqueConstraintViolationException::class
     * 841▕                 : QueryException::class;
     * 842▕
     * ➜ 843▕             $exception = new $exceptionType(
     * 844▕                 $this->getNameWithReadWriteType(),
     * 845▕                 $query,
     * 846▕                 $this->prepareBindings($bindings),
     * 847▕                 $e,
     *
     * 1   vendor\laravel\framework\src\Illuminate\Database\MySqlConnection.php:47
     * PDOException::("SQLSTATE[42S22]: Column not found: 1054 Unknown column 'image' in 'field list'")
     *
     * 2   vendor\laravel\framework\src\Illuminate\Database\MySqlConnection.php:47
     * PDO::prepare("insert into `tour` (`name`, `price`, `description`, `duration`, `image`, `capacity`, `agency_id`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)")
     * Run the database seeds.
     */
    public function run(): void
    {
        $places = Place::all();
        $categoryIds = Category::pluck('id');

        if ($places->isEmpty() || $categoryIds->isEmpty()) {
            return;
        }

        Tour::factory()->count(20)->create()->each(function (Tour $tour) use ($places, $categoryIds) {

            $tour->categories()->attach($categoryIds->random(rand(2, 5)));

            Image::factory()
                ->count(rand(1, 3))
                ->forTour($tour->id)
                ->create();

            $itinerary = $places->random(rand(3, 5))
                ->mapWithKeys(fn($place, $index) => [
                    $place->id => ['position' => $index + 1]
                ]);

            $tour->places()->attach($itinerary);
        });
    }
}
