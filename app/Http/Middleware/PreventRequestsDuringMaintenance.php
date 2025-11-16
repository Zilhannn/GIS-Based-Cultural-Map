<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventRequestsDuringMaintenance
{
    public function handle(Request $request, Closure $next)
    {
        if (app()->isDownForMaintenance()) {
            // Some environments may not have the framework exception available
            // or its constructor signature may differ. Return a 503 response
            // instead so the app correctly signals maintenance mode.
            abort(503);
        }

        return $next($request);
    }
}
