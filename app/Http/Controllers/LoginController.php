<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function display()
    {
        return view('login');
    }

    

    public function login(Request $request){
    $credentials = [];
    
    if ($request->filled('username')) {
        $credentials = $request->only('username', 'password');
    } elseif ($request->filled('email')) {
        $credentials = $request->only('email', 'password');
    } else {
        return back()->withErrors(['login' => 'Debes introducir tus credenciales.']);
    }

    // 2. Intentar autenticar
    // Auth::attempt verifica automáticamente el hash de la password
    if (Auth::attempt($credentials)) {
        // Regenerar sesión por seguridad
        $request->session()->regenerate();

        return redirect()->intended('home'); // Redirige a donde iba o al home
    }

    // 3. Si falla, volver atrás con error
    return back()->withErrors([
        'login' => 'Las credenciales no coinciden con nuestros registros.',
    ])->onlyInput('username', 'email');
}
}