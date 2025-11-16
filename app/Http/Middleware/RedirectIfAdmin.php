<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user && $user->is_admin == 1) {
            // If an admin tries to access the public frontend, redirect to admin dashboard
            return redirect()->route('admin.dashboard_admin');
        }

        return $next($request);
    }
}
