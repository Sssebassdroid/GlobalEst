<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Importación recomendada

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 1. Protección contra nulos (Early Return)
        if ($user === null) {
            Log::error('Intento de acceso al dashboard sin sesión activa.');
            return redirect()->route('login'); // Redirigimos al login por seguridad
        }

        // Limpiamos rastro de sesiones previas de creación
        session()->forget('lugares_seleccionados');

        // 2. Lógica de redirección por Rol
        if ($user->isBusiness()) {
            Log::info('Usuario de tipo empresa [' . $user->id_user . '] redirigido a sus tours.');
            return redirect()->route('tour.index');
        }

        Log::info('Usuario normal [' . $user->id_user . '] redirigido a sus viajes.');
        return view('my-trips');
    }
}