<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

/**
 * Controlador principal del dashboard.
 *
 * Gestiona la redirección inicial del usuario después de autenticarse,
 * enviándolo a la sección correspondiente según su rol.
 */
class DashboardController extends Controller
{
    /**
     * Punto de entrada al dashboard.
     *
     * Flujo:
     * 1. Verifica que exista una sesión activa.
     * 2. Limpia los lugares seleccionados almacenados en sesión.
     * 3. Si el usuario es una empresa, lo redirige a la gestión de tours.
     * 4. Si es un turista, lo redirige a la gestión de viajes.
     *
     */
    public function index()
    {
        $user = auth()->user();

        if ($user === null) {
            Log::error(
                'Intento de acceso al dashboard sin sesión activa.'
            );
            return redirect()->route('login');
        }

        session()->forget('lugares_seleccionados');

        if ($user->isBusiness()) {
            Log::info(
                'Usuario de tipo empresa [' . $user->id_user . '] redirigido a sus tours.'
            );

            return redirect()->route('agency.index');
        }

        Log::info(
            'Usuario normal [' . $user->id_user . '] redirigido a sus viajes.'
        );

        return redirect()->route('tourist.index');
    }
}
