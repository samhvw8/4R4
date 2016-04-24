<?php

namespace r4r\Http\Middleware;

use Closure;
use r4r\Entities\User;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->isAdmin())
            return $next($request);
        else {
            return response()->json([
                "msg" => "Forbidden"
            ], 403);
        }
    }
}
