<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public const int ROLE_AGENCY = 1;
    public const int ROLE_TOURIST = 2;

    public function run(): void
    {
        Role::create(['id' => self::ROLE_AGENCY, 'type' => 'Agencia']);
        Role::create(['id' => self::ROLE_TOURIST, 'type' => 'Turista']);
    }
}
