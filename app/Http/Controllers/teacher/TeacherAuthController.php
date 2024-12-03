<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherAuthController extends Controller
{

    public function loginPage()
    {
      return view('Teacher.Auth.login');
    }

    public function login(Request $request)
    {
        $check = $request->all();
        
        if (Auth::guard('teacher')->attempt([
            'email' => $check['email'],
            'password' => $check['password']
        ])) {
            return redirect()->route('teacher.dashboard');
        } else {
            return redirect()->back()->with('error', 'Invalid email or password');
        }
    }

    public function logout()
    {
        Auth::guard('teacher')->logout();
        return redirect()->route('teacher.login.page');
    }
}