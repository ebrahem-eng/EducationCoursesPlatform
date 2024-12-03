<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TeacherAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('teacher')->check()) {
            return redirect()->route('teacher.login.page');
        }
        return $next($request);
    }
}