<?php

namespace App\Http\Middleware;

use Closure;

class UserMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'user') {
            return redirect()->route('admin.dashboard')
->with('error','No tienes acceso a esa sección');

        }

        return $next($request);
    }
}
