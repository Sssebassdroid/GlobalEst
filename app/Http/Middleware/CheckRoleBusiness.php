<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckRoleBusiness
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            Log::warning('Intento de acceso a ruta Business sin autenticación.', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl()
            ]);
            return redirect()->route('login')->with('error', 'Debes iniciar sesión primero.');
        }

        $user = Auth::user();

        if (!$user->isBusiness()) {
            Log::error('Acceso denegado: El usuario no tiene permisos de Agencia.', [
                'user_id' => $user->id_user,
                'username' => $user->username,
                'role_actual' => $user->role,
                'ip' => $request->ip()
            ]);

            return redirect()->route('tourist.trips')->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        Log::debug('Acceso concedido a zona Business', ['user' => $user->username]);

        return $next($request);
    }
}
