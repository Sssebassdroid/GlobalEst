<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // Importante para usar los logs

class RegisterController extends Controller
{
    public function display()
    {
        return view('register');
    }

    public function registerUser(Request $request)
    {
        $validated = $this->validateUser($request);


        try {
            $user = User::create([
                'username'         => $validated['username'],
                'name'             => $validated['name'],
                'first_last_name'  => $validated['first_last_name'],
                'second_last_name' => $validated['second_last_name'],
                'email'            => $validated['email'],
                'password'         => Hash::make($validated['password']),
                'role_id'             => $validated['role_id'],
            ]);

            Log::info("Nuevo usuario creado correctamente", [
                'id_user'  => $user->id_user,
                'username' => $user->username,
                'email'    => $user->email,
                'role_id'     => $user->role_id,
            ]);

            return redirect('/login')->with('success', '¡Cuenta creada correctamente!');

        } catch (\Exception $e) {
            Log::error("Error al crear usuario: " . $e->getMessage());

            return back()->withInput()->with('error', 'Hubo un error al procesar el registro.');
        }
    }

    protected function validateUser(Request $request)
{
    try {
        return $request->validate([
            'username'         => 'required|string|max:50|unique:user,username',
            'name'             => 'required|string|max:50',
            'first_last_name'  => 'required|string|max:50',
            'second_last_name' => 'nullable|string|max:50',
            'email'            => 'required|email|max:50|unique:user,email',
            'password'         => 'required|string|min:8|confirmed',
            'role_id'             => 'required|integer',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::warning("Fallo en validación de registro", [
            'datos_enviados' => $request->except('password', 'password_confirmation'),
            'errores' => $e->errors()
        ]);
        throw $e;
    }
}
}
