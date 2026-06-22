<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user === null) {
            Log::error(
                'Intento de acceso al dashboard sin sesión activa.'
            );
            return redirect()->route('login');
        }

        session()->forget('cambialo');

        if ($user->isAgency()) {
            Log::info(
                'Usuario de tipo empresa [' . $user->id . '] redirigido a sus tours.'
            );

            return redirect()->route('agency.index');
        }

        Log::info(
            'Usuario normal [' . $user->id . '] redirigido a sus viajes.'
        );

        return redirect()->route('tourist.index');
    }
}
