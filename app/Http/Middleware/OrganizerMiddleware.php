<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->is_organizer && !Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещен. Только для организаторов и администраторов.');
        }

        return $next($request);
    }
}
