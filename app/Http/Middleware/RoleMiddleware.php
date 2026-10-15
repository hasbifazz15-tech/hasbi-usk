<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        string $role
    ): Response {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (strtolower(trim((string) $user->role)) !== strtolower(trim($role))) {
            abort(
                403,
                'Email terbaca: ' . $user->email .
                ' | Role terbaca: ' . $user->role .
                ' | Role yang dibutuhkan: ' . $role
            );
        }

        return $next($request);
    }
}