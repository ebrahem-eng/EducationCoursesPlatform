<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentAuthController extends Controller
{

    public function loginPage()
    {
        return view('Student.Auth.login');
    }

    public function login(Request $request)
    {
        $check = $request->all();

        $student = Student::where('email', $check['email'])->first();

        // First check if student exists
        if (!$student) {
            return redirect()->back()->with('error_message', 'Invalid email or password');
        }

        // Then check block status
        if ($student->block == 1) {
            return redirect()->back()->with('error_message', 'Your account has been blocked');
        }

        // Then check active status
        if ($student->status == 0) {
            return redirect()->back()->with('error_message', 'Your account is not activated yet');
        }

        
        if (Auth::guard('student')->attempt([
            'email' => $check['email'],
            'password' => $check['password']
        ])) {
            return redirect()->route('home');
        } else {
            return redirect()->back()->with('error_message', 'Invalid password');
        }
    }

    public function registerPage()
    {
        return view('Student.Auth.register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:students',
            'password' => 'required|min:6',
            'gender' => 'required',
            'age' => 'required',
            'phone' => 'required',
            'img' => 'required',
        ]);

        $student = Student::where('email' , $validatedData['email'])->first();
        if($student){
            return redirect()->back()->with('error_message', 'Email already exists');
        }

        $userImageDirectory = 'StudentImage/' . $student->id;
        Storage::disk('image')->delete($student->img);
        $image = $request->file('img')->getClientOriginalName();
        $path = $request->file('img')->storeAs($userImageDirectory, $image, 'image');

        Student::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'gender' => $validatedData['gender'],
            'age' => $validatedData['age'],
            'phone' => $validatedData['phone'],
            'img' => $path,
            'status' => '1'
        ]);
        return redirect()->route('student.login.page')->with('success_message', 'Registered successfully');
    }

    public function logout()
    {
        Auth::guard('student')->logout();
        return redirect()->route('home');
    }


}
