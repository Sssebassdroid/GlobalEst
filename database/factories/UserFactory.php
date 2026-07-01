<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Agency;
use Database\Seeders\RoleSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'name'=> $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'second_last_name' => $this->faker->optional()->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password123'),
            'role_id' => RoleSeeder::ROLE_TOURIST,
            'created_at' => now(),
            'updated_at' => now(),
            'remember_token' => null,
        ];
    }

    public function asAgency(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => RoleSeeder::ROLE_AGENCY,
            ];
        })->afterCreating(function (User $user) {
            if (!$user->agency()->exists()) {
                Agency::create([
                    'name' => $this->faker->company() . ' Tours',
                    'user_id' => $user->id,
                ]);
            }
        });
    }
}
