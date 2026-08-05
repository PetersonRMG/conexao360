<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PerfilMiddleware
{
public function handle(Request $request, Closure $next, string $perfil): Response
{
    //dd('perfil middleware');

    $usuario = Auth::guard('admin')->user();

    if (!$usuario) {
        abort(403);
    }

    if ($usuario->perfil_usuario !== $perfil) {
        abort(403);
    }

    return $next($request);
}
}