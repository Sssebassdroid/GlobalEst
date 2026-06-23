<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('continent')->insert([
            ['id_continent' => 1, 'name' => 'Europa'],
            ['id_continent' => 2, 'name' => 'América'],
            ['id_continent' => 3, 'name' => 'Asia'],
            ['id_continent' => 4, 'name' => 'Oceania'],
            ['id_continent' => 5, 'name' => 'África'],
        ]);

        DB::table('role')->insert([
            ['id_role' => 1, 'type' => 'Agencia'],
            ['id_role' => 2, 'type' => 'Turista'],
        ]);

        DB::table('category')->insert([
            ['id_category' => 1, 'name' => 'Histórico'],
            ['id_category' => 2, 'name' => 'Gastronómico'],
        ]);

        DB::table('country')->insert([
            ['id_country' => 1, 'name' => 'Italia', 'continent_id' => 1],
            ['id_country' => 2, 'name' => 'España', 'continent_id' => 1],
            ['id_country' => 3, 'name' => 'Perú', 'continent_id' => 2],
            ['id_country' => 4, 'name' => 'Bolivia', 'continent_id' => 2],
        ]);

        DB::table('user')->insert([
            [
                'id_user' => 1,
                'username' => 'admin',
                'name' => 'admin',
                'first_last_name' => 'admin',
                'second_last_name' => null,
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'role_id' => 1,
            ],
            [
                'id_user' => 2,
                'username' => 'cuentaEmpresa',
                'name' => 'cuentaEmpresa',
                'first_last_name' => 'cuentaEmpresa',
                'second_last_name' => 'cuentaEmpresa',
                'email' => 'cuentaEmpresa@cuentaEmpresa.com',
                'password' => Hash::make('cuentaEmpresa'),
                'role_id' => 1,
            ],
            [
                'id_user' => 3,
                'username' => 'cuentaTurista',
                'name' => 'cuentaTurista',
                'first_last_name' => 'cuentaTurista',
                'second_last_name' => null,
                'email' => 'cuentaTurista@cuentaTurista.com',
                'password' => Hash::make('cuentaTurista'),
                'role_id' => 2,
            ],
        ]);

        DB::table('city')->insert([
            ['id_city' => 1, 'name' => 'Perugia', 'country_id' => 1],
            ['id_city' => 2, 'name' => 'Madrid', 'country_id' => 2],
        ]);

        DB::table('agency')->insert([
            ['id_agency' => 1, 'agency_name' => 'GlobalEst Perugia', 'user_id' => 1],
            ['id_agency' => 2, 'agency_name' => 'Madrid Tours', 'user_id' => 2],
        ]);

        DB::table('place_available')->insert([
            [
                'id_place' => 1,
                'name' => 'Fontana Maggiore',
                'display_name' => 'Piazza IV Novembre, Perugia',
                'latitude' => 43.1121,
                'longitude' => 12.3888,
                'importance' => 0.95,
                'osm_id' => 12345678,
                'osm_type' => 'way',
                'city_id' => 1
            ],
            [
                'id_place' => 2,
                'name' => 'Puerta del Sol',
                'display_name' => 'Puerta del Sol, Madrid',
                'latitude' => 40.4167,
                'longitude' => -3.7033,
                'importance' => null,
                'osm_id' => null,
                'osm_type' => null,
                'city_id' => 2
            ],
        ]);



       DB::table('tour')->insert([
            [
                'id_tour' => 1,
                'tour_name' => 'Perugia Medieval',
                'tour_price' => 25.00,
                'description' => 'Tour detallado por el centro histórico.',
                'estimated_duration' => '02:00:00',
                'image' => 'perugia.jpg',
                'agency_id' => 1,
            ],
            [
                'id_tour' => 2,
                'tour_name' => 'Madrid Express',
                'tour_price' => 15.00,
                'description' => null,
                'estimated_duration' => '01:30:00',
                'image' => null,
                'agency_id' => 2,
            ],
        ]);



        DB::table('category_tour')->insert([
            ['id_category_tour' => 1, 'category_id' => 1, 'tour_id' => 2],
            ['id_category_tour' => 2, 'category_id' => 2, 'tour_id' => 1],
        ]);

        DB::table('booking')->insert([
            ['id_order' => 1, 'order_date' => '2026-05-10 10:00:00', 'total_amount' => 50.00, 'user_id' => 3],
            ['id_order' => 2, 'order_date' => '2026-05-11 12:30:00', 'total_amount' => 15.00, 'user_id' => 3],
        ]);



        DB::table('place_tour')->insert([
            ['id_places_tour' => 1, 'order_position' => 1, 'place_id' => 1, 'tour_id' => 1],
            ['id_places_tour' => 2, 'order_position' => 1, 'place_id' => 2, 'tour_id' => 2],
        ]);

        DB::table('occurrence')->insert([
            [
                'id_occurrence' => 1,
                'date_occurrence' => '2026-05-15',
                'start_hour' => '10:00:00',
                'maximum_person' => 20,
                'tour_id' => 1
            ],
            [
                'id_occurrence' => 2,
                'date_occurrence' => '2026-05-16',
                'start_hour' => '12:00:00',
                'maximum_person' => 15,
                'tour_id' => 2
            ],
        ]);

        DB::table('reviews')->insert([
            [
                'id_review' => 1,
                'rating' => 5,
                'comment' => 'Excelente tour histórico',
                'user_id' => 3,
                'tour_id' => 1
            ],
            [
                'id_review' => 2,
                'rating' => 4,
                'comment' => null,
                'user_id' => 3,
                'tour_id' => 2
            ],
        ]);

        DB::table('booking_details')->insert([
            [
                'id_booking_details' => 1,
                'quantity' => 2,
                'subtotal' => 50.00,
                'order_id' => 1,
                'occurrence_id' => 1
            ],
            [
                'id_booking_details' => 2,
                'quantity' => 1,
                'subtotal' => 15.00,
                'order_id' => 2,
                'occurrence_id' => 2
            ],
        ]);


    }
}
