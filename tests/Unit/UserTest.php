<?php

namespace Tests\Unit;

use Tests\TestCase; 
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase; // Esto asegura que las tablas se creen antes de cada test
  public function test_user_can_be_identified_as_business() {
    $user = User::make([ // Usamos make para no persistir si no es necesario, o create
        'username' => 'test_biz',
        'email' => 'biz@test.com',
        'role_id' => 1 // <--- IMPORTANTE: ID de Empresa
    ]);
    
    $this->assertTrue($user->isBusiness());
}

 public function test_user_can_be_identified_as_normal_user() {
    $user = User::make([
        'username' => 'test_turista',
        'email' => 'turista@test.com',
        'role_id' => 2 // <--- IMPORTANTE: ID de Turista
    ]);
    
    $this->assertFalse($user->isBusiness());
}



}
