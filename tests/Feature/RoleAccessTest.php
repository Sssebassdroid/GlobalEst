<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_turista_bloqueado_my_tours()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
        $turista = User::where('role_id', 2)->first();

        $response = $this->actingAs($turista)->get('/my-tours');

        $response->assertRedirect('/my-trips');
    }

    public function test_empresa_acceso_my_tours()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
        $empresa = User::where('role_id', 1)->first();

        $response = $this->actingAs($empresa)->get('/my-tours');

        $response->assertStatus(200);
    }
}