<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckRoleBusiness
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Verificamos si el usuario está autenticado
        if (!Auth::check()) {
            Log::warning('Intento de acceso a ruta Business sin autenticación.', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl()
            ]);
            return redirect()->route('login')->with('error', 'Debes iniciar sesión primero.');
        }

        $user = Auth::user();

        // 2. Verificamos el rol (Usando el método isBusiness que creamos en el modelo User)
        // Rol 1 = Business / Agencia
        if (!$user->isBusiness()) {
            Log::error('Acceso denegado: El usuario no tiene permisos de Agencia.', [
                'user_id' => $user->id_user,
                'username' => $user->username,
                'role_actual' => $user->role,
                'ip' => $request->ip()
            ]);

            // Si es un turista intentando entrar a zona de agencia, lo mandamos a su sitio
            return redirect()->route('tourist.trips')->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        // 3. Log de éxito (Opcional, útil en desarrollo)
        Log::debug('Acceso concedido a zona Business', ['user' => $user->username]);

        return $next($request);
    }
}