<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class StudentAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('student')->check()) {
            return redirect()->route('student.login.page')->with('error_message', 'Please login first');
        }

        if (Auth::guard('student')->user()->block) {
            return redirect()->route('student.login.page')->with('error_message', 'Your account has been blocked');
        }

        if (Auth::guard('student')->user()->status == 0) {
            return redirect()->route('student.login.page')->with('error_message', 'Your account is not activated yet');
        }

        return $next($request);
    }
}
