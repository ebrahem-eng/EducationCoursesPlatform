<?php

namespace App\Http\Controllers\Student\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseChatMessage;
use App\Models\CourseModuleVideo;
use App\Models\CourseModelExam;
use App\Models\StudentCourse;
use App\Models\Teacher;
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

    public function CourseModule($id)
    {
        $course = Course::where('id' , $id)->first();
        if(!$course){
            return redirect()->back()->with('error_message' , 'course not found');
        }

        return view('student.Course.CourseModule' , compact('course') );
    }

    public function chat($course_id, $teacher_id)
    {
        $course = Course::findOrFail($course_id);
        $teacher = Teacher::findOrFail($teacher_id);
        $student_id = Auth::guard('student')->id();

        $enrollment = StudentCourse::where('course_id', $course_id)
            ->where('student_id', $student_id)
            ->first();

        if (!$enrollment) {
            return redirect()->route('student.course.index')
                             ->with('error_message', 'أنت غير مسجل في هذه الدورة.');
        }

        // عرض فقط رسائل الطالب
        $messages = CourseChatMessage::where('course_id', $course_id)
            ->where('student_id', $student_id)
            ->where('teacher_id', $teacher_id)
            ->orderBy('created_at', 'asc')
            ->get();

        // لا داعي لتحديث is_read هنا لأن المدرس لن يرسل رسائل

        return view('Student.Course.chat', compact('course', 'teacher', 'messages') + ['student' => Auth::guard('student')->user()]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'required|exists:teachers,id',
            'message' => 'required|string'
        ]);

        $course = Course::findOrFail($request->course_id);
        $student_id = Auth::guard('student')->id();

        // التأكد من أن الطالب مسجل في الدورة
        $enrollment = StudentCourse::where('course_id', $request->course_id)
            ->where('student_id', $student_id)
            ->first();

        if (!$enrollment) {
            return response()->json([
                'success' => false,
                'message' => 'أنت غير مسجل في هذه الدورة.'
            ], 403);
        }

        $message = CourseChatMessage::create([
            'course_id' => $request->course_id,
            'student_id' => $student_id,
            'teacher_id' => $request->teacher_id,
            'content' => $request->message,
            'sender_type' => 'student',
            'is_read' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'content' => $message->content,
                'sender_type' => 'student',
                'created_at' => $message->created_at->format('M d, Y H:i')
            ]
        ]);
    }

    public function courseContent($id)
    {
        $course = Course::with(['modules.courseModuleVideos', 'modules.courseModelExams', 'modules.courseModuleHomeWorks'])->find($id);
        if (!$course) {
            return redirect()->back()->with('error_message', 'Course not found');
        }
        return view('Student.Course.CourseContent', compact('course'));
    }

    
    public function videoShow($course_id, $id)
    {
        $course = Course::findOrFail($course_id);
        $video = CourseModuleVideo::findOrFail($id); // ← نأتي بالفيديو مباشرة من الجدول الصحيح
    
        return view('Student.Course.CourseVideo', compact('video', 'course'));
    }

    public function examShow($course_id ,$id)
    {
        $course = Course::findOrFail($course_id);
        $exams = CourseModelExam::findOrFail($id);
        return view('Student.Course.CourseExam', compact('course', 'exams'));

    }
    

}
