<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase; // Fundamental para que cada test empiece de cero

    /** @test */
    public function un_usuario_puede_registrarse_con_todos_los_campos_incluyendo_opcionales()
    {
        $datos = [
            'username' => 'sebastian_pro',
            'name' => 'Sebastian',
            'first_last_name' => 'Tovar',
            'second_last_name' => 'Delgado', // Campo opcional presente
            'email' => 'sebastian@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 2,
        ];

        $response = $this->post('/register', $datos);

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('user', $datos); // Verifica que todos los campos coincidan
    }

    /** @test */
    public function un_usuario_puede_registrarse_sin_el_segundo_apellido()
    {
        $response = $this->post('/register', [
            'username' => 'admin_user',
            'name' => 'Admin',
            'first_last_name' => 'Global',
            'second_last_name' => null, // O simplemente no enviarlo
            'email' => 'admin@globalest.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 1,
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('user', ['username' => 'admin_user', 'second_last_name' => null]);
    }
}
