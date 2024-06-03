<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth("api")->check()) {
            if (auth("api")->user()->roles->count() > 0 ||
                auth("api")->user()->permissions->count() > 0)
                return $next($request);
            return \response()->json(["error" => "access denied"], 403);
        }
        return \response()->json(["error" => "Unauthorized"], 401);
    }
}
