<?php

namespace App\Http\Controllers;

use App\Actions\RegisterUserAction;
use App\DTOs\UserDTO;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function display(): Renderable
    {
        $roles = Role::all();
        return view('register', compact('roles'));
    }


    public function registerUser(RegisterRequest $request, RegisterUserAction $registerUser): RedirectResponse
    {
        try {
            $userDTO = UserDTO::fromRequest($request);

            $registerUser->execute($userDTO);

            return redirect('/login')->with('success', '¡Cuenta creada correctamente!');

        } catch (\Exception $e) {
            Log::error("Error al crear usuario en controlador: " . $e->getMessage());

            return back()->withInput()->with('error', 'Hubo un error al procesar el registro.');
        }
    }
}
