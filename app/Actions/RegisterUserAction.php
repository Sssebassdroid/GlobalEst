<?php

namespace App\Actions;

use App\Models\User;
use App\DTOs\UserDTO;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterUserAction
{
    public function execute(UserDTO $dto): User
    {
        $user = User::create([
            'username'         => $dto->username,
            'name'             => $dto->name,
            'first_last_name'  => $dto->firstLastName,
            'second_last_name' => $dto->secondLastName,
            'email'            => $dto->email,
            'password'         => Hash::make($dto->password),
            'role_id'          => $dto->roleId,
        ]);

        Log::info("Nuevo usuario creado correctamente", [
            'id'       => $user->id,
            'username' => $user->username,
            'email'    => $user->email,
            'role_id'  => $user->role_id,
        ]);

        return $user;
    }
}
