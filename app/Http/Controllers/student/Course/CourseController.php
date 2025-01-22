<?php

namespace App\Http\Controllers\Student\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\StudentCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    //

    public function courseDetails($id)
    {
        $course = Course::where('id' , $id)->first();
        if(!$course){
            return redirect()->back()->with('error_message' , 'course not found');
        }

        return view('student.Course.CourseDetails' , compact('course') );
    }


    public function register($id)
    {
        $course = Course::where('id' , $id)->first();
        if(!$course){
            return redirect()->back()->with('error_message' , 'course not found');
        }
        if($course->status != 1){
            return redirect()->back()->with('error_message' , 'course is not active');
        }

        $student = Auth::guard('student')->user();
        $checkStudent = StudentCourse::where('student_id' , $student->id)->where('course_id' , $course->id)->first();
        if($checkStudent){
            return redirect()->back()->with('error_message' , 'you have already registered this course');
        }
        StudentCourse::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'status' => 1
        ]);
        return redirect()->back()->with('success_message' , 'you have successfully registered this course');
    }

    public function myCourses()
    {
        $student = Auth::guard('student')->user();
        return view('Student.Course.MyCourses' , compact('student'));

    }
}
