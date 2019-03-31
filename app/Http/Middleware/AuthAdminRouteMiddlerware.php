<?php

namespace App\Http\Middleware;

use Admin\Services\PermissionService;
use App\Exceptions\Auth\AuthAdminRouteException;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthAdminRouteMiddlerware
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->user()->hasRole('super-admin')) {
            return $next($request);
        }

        $route = $request->path();
        $routes = PermissionService::server()->getAuthRoutes();
        if (in_array($route, $routes)) {
            return $next($request);
        }

        throw new AuthAdminRouteException();
    }
}
