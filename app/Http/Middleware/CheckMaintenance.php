<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Don't block admin routes, login, logout, or assets
        if ($request->is('admin*') || $request->is('login') || $request->is('logout') || $request->is('_debugbar*')) {
            return $next($request);
        }

        // Check if maintenance mode is enabled in database
        try {
            $setting = \App\Models\Setting::instance();
            if ($setting && $setting->maintenance_mode) {
                return response()->view('errors.503', [], 503);
            }
        } catch (\Exception $e) {
            // Ignore if database is not set up yet
        }

        return $next($request);
    }
}
