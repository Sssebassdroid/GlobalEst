<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_registro_usuario()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $response = $this->post('/register', [
            'username' => 'testuser',
            'name' => 'Test',
            'first_last_name' => 'User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role_id' => 2
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('user', ['email' => 'test@example.com']);
    }

    public function test_login_usuario()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $response = $this->post('/login', [
            'email' => 'cuentaTurista@cuentaTurista.com',
            'password' => 'cuentaTurista',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticated();
    }
}