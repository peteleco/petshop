<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class EnsureUserAdmin
{
    /**
     * @throws \Throwable
     */
    public function handle(Request $request, Closure $next): mixed
    {
        throw_if(! $this->isAdmin($request->user()), AccessDeniedHttpException::class, __('Access denied.'));

        return $next($request);
    }

    public function isAdmin(?User $user): bool
    {
        return $user && $user->isAdmin();
    }
}
