<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAuthController extends Controller
{
    public function login(Request $request)
    {
        $check = $request->all();
        
        if (Auth::guard('student')->attempt([
            'email' => $check['email'],
            'password' => $check['password']
        ])) {
            return redirect()->route('student.dashboard');
        } else {
            return redirect()->back()->with('error', 'Invalid email or password');
        }
    }
}