<?php

namespace Masoudi\Laravel\Visitors\Middlewares;

use Closure;
use Illuminate\Http\Request;

class VisitMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $request->visit();
        return $next($request);
    }
}