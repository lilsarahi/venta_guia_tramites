<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Pago;

class VerificarPagoToken
{
    public function handle(Request $request, Closure $next)
    {
        $slug  = $request->route('slug');
        $token = $request->route('token');

        $pago = Pago::where('slug', $slug)
            ->where('token_acceso', $token)
            ->where('estado', 'completado')
            ->first();

        if (!$pago) {
            return redirect()->route('tramites.show', $slug)
                ->with('error', 'Acceso no válido.');
        }

        return $next($request);
    }
}