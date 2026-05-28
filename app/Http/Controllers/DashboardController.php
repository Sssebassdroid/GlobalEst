<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
    
        if ($user === null) {
            Log::error('Intento de acceso al dashboard sin sesión activa.');
            return redirect()->route('login'); // Redirigimos al login por seguridad
        }

        session()->forget('lugares_seleccionados');

        if ($user->isBusiness()) {
            Log::info('Usuario de tipo empresa [' . $user->id_user . '] redirigido a sus tours.');
            return redirect()->route('tour.index');
        }

        Log::info('Usuario normal [' . $user->id_user . '] redirigido a sus viajes.');
        return redirect()->route('tourist.trips'); // Redirige a /my-trips
    }
}