<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Agency;
use Database\Seeders\RoleSeeder;

class AgencySeeder extends Seeder
{
    public function run(): void
    {
        $usuariosAgencia = User::where('role_id', RoleSeeder::ROLE_AGENCY)
            ->doesntHave('agency')
            ->get();

        foreach ($usuariosAgencia as $user) {
            Agency::factory()->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
