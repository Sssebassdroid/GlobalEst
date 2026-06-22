<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class EnsureAgencyHasProfile
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // 1. Si no es agencia, lo sacamos de aquí (seguridad)
        if (!$user || !$user->isAgency()) {
            return redirect()->route('tourist.trips');
        }

        // 2. Si es agencia, pero no tiene perfil en la tabla 'agency'
        if (!$user->agency) {
            Log::info('Usuario Business sin agencia. Redirigiendo a Setup.', ['user_id' => $user->id]);

            // Buena práctica UX: En vez de un error, lo mandamos a una pantalla para que cree su agencia.
            return redirect()->route('agency.setup')
                ->with('warning', 'Para empezar a publicar tours, primero configura los datos de tu agencia.');
        }

        // 3. Si todo está bien, lo dejamos pasar al Controlador
        return $next($request);
    }
}
