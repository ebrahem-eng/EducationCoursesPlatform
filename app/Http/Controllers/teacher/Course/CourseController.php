<?php

namespace App\Http\Controllers\teacher\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    //

    public function index()
    {
        $courses = Course::where('teacher_id', Auth::guard('teacher')->user()->id)->get();
        return view('Teacher.Course.index', compact('courses'));
    }
}
