<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->asAgency()->create([
            'username' => 'cuentaAgencia',
            'name' => 'cuentaAgencia',
            'last_name' => 'cuentaAgencia',
            'email' => 'cuentaAgencia@cuentaAgencia.com',
            'password' => Hash::make('cuentaAgencia'),
        ]);

        User::factory()->create([
            'username' => 'cuentaTurista',
            'name' => 'cuentaTurista',
            'last_name' => 'cuentaTurista',
            'email' => 'cuentaTurista@cuentaTurista.com',
            'password' => Hash::make('cuentaTurista'),
        ]);

        User::factory()->count(5)->asAgency()->create();

        User::factory()->count(10)->create();
    }
}
