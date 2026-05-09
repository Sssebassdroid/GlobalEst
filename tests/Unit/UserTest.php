<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_user_can_be_identified_as_business(){
    $user = new \App\Models\User(['role' => 1]); 
    $this->assertTrue($user->isBusiness());
    }

    public function test_user_can_be_identified_as_normal_user(){
    $user = new \App\Models\User(['role' => 2]); 
    $this->assertTrue($user->isNormalUser());
    }



}
