<?php

namespace Database\Factories;

use App\Models\Agency;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Agency>
 */
class AgencyFactory extends Factory
{
    protected $model = Agency::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'user_id' => User::factory()->state([
                'role_id' => RoleSeeder::ROLE_AGENCY,])
        ];
    }
}
