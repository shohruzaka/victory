<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || $request->user()->role !== UserRole::ADMIN) {
            abort(403, 'Ushbu sahifaga kirish uchun sizda yetarli huquqlar mavjud emas.');
        }

        return $next($request);
    }
}
