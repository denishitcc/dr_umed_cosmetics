<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermissionMiddleware
{
    public function handle($request, Closure $next, ...$permissions)
    {
        foreach ($permissions as $permission) {
            if (\Auth::user()->checkPermission($permission)) {
                return $next($request);
            }
        }

        abort(403, 'You are not authorized to access this page.');
    }
}
