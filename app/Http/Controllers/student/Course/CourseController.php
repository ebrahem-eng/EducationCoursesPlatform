<?php

namespace App\Http\Controllers\Student\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseChatMessage;
use App\Models\CourseModuleVideo;
use App\Models\CourseModelExam;
use App\Models\StudentCourse;
use App\Models\Teacher;
use App\Models\VideoProgress;
use App\Models\StudentSubmission;
use App\Models\CourseProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseModelHomework;
use Carbon\Carbon;
use App\Models\CourseModuleHomeWork;

class CourseController extends Controller
{
    public function search(Request $request)
    {
        $query = Course::query()->where('status', 1);

        // Search by name or code
        if ($request->filled('query')) {
            $searchTerm = $request->query;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('code', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }

        // Filter by duration
        if ($request->filled('duration')) {
            $duration = explode('-', $request->duration);
            if (count($duration) === 2) {
                $query->whereBetween('duration', [$duration[0], $duration[1]]);
            } elseif ($request->duration === '12+') {
                $query->where('duration', '>=', 12);
            }
        }

        $courses = $query->with(['teacher', 'students', 'modules'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(12);

        // Get categories for the filter dropdown
        $categories = \App\Models\Category::all();

        return view('welcome', compact('courses', 'categories'));
    }

    public function courseDetails($id)
    {
        $course = Course::with(['teacher', 'modules.courseModuleVideos', 'modules.courseModelExams', 'modules.courseModuleHomeWorks'])
            ->findOrFail($id);

        $studentProgress = null;
        if (Auth::guard('student')->check()) {
            $studentProgress = CourseProgress::where([
                'student_id' => Auth::guard('student')->id(),
                'course_id' => $id
            ])->first();
        }

        return view('student.Course.CourseDetails', compact('course', 'studentProgress'));
    }

    public function register($id)
    {
        $course = Course::findOrFail($id);
        
        if ($course->status != 1) {
            return redirect()->back()->with('error_message', 'Course is not active');
        }

        $student = Auth::guard('student')->user();
        
        if (StudentCourse::where(['student_id' => $student->id, 'course_id' => $id])->exists()) {
            return redirect()->back()->with('error_message', 'You have already registered for this course');
        }

        // Create course registration
        StudentCourse::create([
            'student_id' => $student->id,
            'course_id' => $id,
            'status' => 1
        ]);

        // Initialize course progress
        CourseProgress::create([
            'student_id' => $student->id,
            'course_id' => $id,
            'completed_videos' => 0,
            'completed_assignments' => 0,
            'completed_exams' => 0,
            'overall_progress' => 0
        ]);

        return redirect()->back()->with('success_message', 'Successfully registered for the course');
    }

    public function myCourses()
    {
        $student = Auth::guard('student')->user();
        $courses = StudentCourse::where('student_id', $student->id)
            ->with(['course.modules', 'course.teacher'])
            ->get();

        foreach ($courses as $enrollment) {
            $progress = CourseProgress::where([
                'student_id' => $student->id,
                'course_id' => $enrollment->course_id
            ])->first();

            $enrollment->progress = $progress ? $progress->overall_progress : 0;
        }

        return view('Student.Course.MyCourses', compact('courses'));
    }

    public function courseContent($id)
    {
        $student = Auth::guard('student')->user();
        $course = Course::with([
            'modules.courseModuleVideos',
            'modules.courseModelExams',
            'modules.courseModuleHomeWorks',
            'teacher'
        ])->findOrFail($id);

        // Get progress for all content
        $videoProgress = VideoProgress::where('student_id', $student->id)
            ->whereIn('video_id', $course->modules->pluck('courseModuleVideos')->flatten()->pluck('id'))
            ->where('completed', true)
            ->get()
            ->keyBy('video_id');

        $examSubmissions = StudentSubmission::where('student_id', $student->id)
            ->whereIn('submittable_id', $course->modules->pluck('courseModelExams')->flatten()->pluck('id'))
            ->where('submittable_type', CourseModelExam::class)
            ->where('completed', true)
            ->get()
            ->keyBy('submittable_id');

        $homeworkSubmissions = StudentSubmission::where('student_id', $student->id)
            ->whereIn('submittable_id', $course->modules->pluck('courseModuleHomeWorks')->flatten()->pluck('id'))
            ->where('submittable_type', CourseModuleHomeWork::class)
            ->where('completed', true)
            ->get()
            ->keyBy('submittable_id');

        // Calculate overall progress
        $totalItems = $course->modules->pluck('courseModuleVideos')->flatten()->count() +
                     $course->modules->pluck('courseModelExams')->flatten()->count() +
                     $course->modules->pluck('courseModuleHomeWorks')->flatten()->count();

        $completedItems = $videoProgress->count() + $examSubmissions->count() + $homeworkSubmissions->count();

        $overallProgress = $totalItems > 0 ? ($completedItems / $totalItems) * 100 : 0;

        // Update or create course progress
        $courseProgress = CourseProgress::updateOrCreate(
            [
                'student_id' => $student->id,
                'course_id' => $id
            ],
            [
                'completed_videos' => $videoProgress->count(),
                'completed_exams' => $examSubmissions->count(),
                'completed_assignments' => $homeworkSubmissions->count(),
                'overall_progress' => $overallProgress
            ]
        );

        return view('Student.Course.CourseContent', compact(
            'course',
            'videoProgress',
            'examSubmissions',
            'homeworkSubmissions',
            'courseProgress'
        ));
    }

    public function markVideoComplete(Request $request, $course_id, $id)
    {
        $student = Auth::guard('student')->user();
        $video = CourseModuleVideo::findOrFail($id);

        // Verify the video belongs to the correct course
        if ($video->courseModule->course_id != $course_id) {
            return response()->json(['success' => false, 'message' => 'Invalid video for this course'], 400);
        }

        $progress = VideoProgress::updateOrCreate(
            [
                'student_id' => $student->id,
                'video_id' => $id
            ],
            [
                'completed' => true,
                'last_watched_at' => now()
            ]
        );

        // Update course progress
        $courseProgress = CourseProgress::firstOrCreate(
            [
                'student_id' => $student->id,
                'course_id' => $course_id
            ],
            [
                'completed_videos' => 0,
                'completed_assignments' => 0,
                'completed_exams' => 0,
                'overall_progress' => 0
            ]
        );

        // Count completed videos for this course
        $completedVideos = VideoProgress::where('student_id', $student->id)
            ->whereHas('video', function($query) use ($course_id) {
                $query->whereHas('courseModule', function($q) use ($course_id) {
                    $q->where('course_id', $course_id);
                });
            })
            ->where('completed', true)
            ->count();

        $courseProgress->completed_videos = $completedVideos;
        $courseProgress->save();
        $courseProgress->calculateProgress();

        return response()->json(['success' => true]);
    }

    public function submitAssignment(Request $request, $homeworkId)
    {
        $student = Auth::guard('student')->user();
        
        $submission = StudentSubmission::create([
            'student_id' => $student->id,
            'submittable_type' => CourseModuleHomeWork::class,
            'submittable_id' => $homeworkId,
            'answers' => $request->answers,
            'submitted_at' => now()
        ]);

        $score = $submission->grade();

        return response()->json([
            'success' => true,
            'score' => $score,
            'feedback' => $submission->feedback
        ]);
    }

    public function submitExam(Request $request, $id)
    {
        $student = Auth::guard('student')->user();
        $exam = CourseModelExam::with(['questions', 'module'])->findOrFail($id);
        
        // Check if student has already submitted this exam
        $existingSubmission = StudentSubmission::where([
            'student_id' => $student->id,
            'submittable_type' => CourseModelExam::class,
            'submittable_id' => $id
        ])->first();
        
        if ($existingSubmission) {
            return response()->json([
                'success' => false,
                'message' => 'You have already submitted this exam.'
            ], 400);
        }

        $validatedData = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string'
        ]);

        // Calculate score
        $score = 0;
        $totalMarks = 0;
        $feedback = [];

        foreach ($exam->questions as $question) {
            $totalMarks += $question->mark;
            if (isset($validatedData['answers'][$question->id]) && 
                $validatedData['answers'][$question->id] === $question->correct_answer) {
                $score += $question->mark;
                $feedback[$question->id] = [
                    'correct' => true,
                    'mark' => $question->mark
                ];
            } else {
                $feedback[$question->id] = [
                    'correct' => false,
                    'mark' => 0,
                    'correct_answer' => $question->correct_answer
                ];
            }
        }

        $submission = StudentSubmission::create([
            'student_id' => $student->id,
            'submittable_type' => CourseModelExam::class,
            'submittable_id' => $id,
            'answers' => $validatedData['answers'],
            'score' => $score,
            'completed' => true,
            'submitted_at' => now(),
            'feedback' => $feedback
        ]);

        // Update course progress
        $courseProgress = CourseProgress::where([
            'student_id' => $student->id,
            'course_id' => $exam->module->course_id
        ])->first();

        if ($courseProgress) {
            $courseProgress->completed_exams = StudentSubmission::where('student_id', $student->id)
                ->whereIn('submittable_id', $exam->module->course->modules->pluck('courseModelExams')->flatten()->pluck('id'))
                ->where('submittable_type', CourseModelExam::class)
                ->where('completed', true)
                ->count();
            $courseProgress->updateOverallProgress();
            $courseProgress->save();
        }

        return response()->json([
            'success' => true,
            'score' => $score,
            'total_marks' => $totalMarks,
            'feedback' => $feedback
        ]);
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

    public function videoShow($course_id, $id)
    {
        $course = Course::findOrFail($course_id);
        $video = CourseModuleVideo::findOrFail($id); // ← نأتي بالفيديو مباشرة من الجدول الصحيح
    
        return view('Student.Course.CourseVideo', compact('video', 'course'));
    }

    public function examShow($course_id, $id)
    {
        $course = Course::findOrFail($course_id);
        $exams = CourseModelExam::with('questions')->findOrFail($id);
        return view('Student.Course.CourseExam', compact('course', 'exams'));
    }

    public function homeworkShow($course_id, $id)
    {
        $course = Course::findOrFail($course_id);
        $homework = CourseModuleHomeWork::with(['questions', 'courseModule'])->findOrFail($id);
        
        return view('Student.Course.CourseHomework', compact('course', 'homework'));
    }

    public function submitHomework(Request $request, $id)
    {
        $student = Auth::guard('student')->user();
        $homework = CourseModuleHomeWork::with(['questions', 'courseModule'])->findOrFail($id);

        // Check if student has already submitted this homework
        $existingSubmission = StudentSubmission::where([
            'student_id' => $student->id,
            'submittable_type' => CourseModuleHomeWork::class,
            'submittable_id' => $id
        ])->first();
        
        if ($existingSubmission) {
            return response()->json([
                'success' => false,
                'message' => 'You have already submitted this homework.'
            ], 400);
        }

        if (Carbon::now()->gt($homework->deadline)) {
            return response()->json([
                'success' => false,
                'message' => 'The deadline for this homework has passed.'
            ], 403);
        }

        $validatedData = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string'
        ]);

        // Calculate score
        $score = 0;
        $totalMarks = 0;
        $feedback = [];

        foreach ($homework->questions as $question) {
            $totalMarks += $question->mark;
            if (isset($validatedData['answers'][$question->id]) && 
                $validatedData['answers'][$question->id] === $question->correct_answer) {
                $score += $question->mark;
                $feedback[$question->id] = [
                    'correct' => true,
                    'mark' => $question->mark
                ];
            } else {
                $feedback[$question->id] = [
                    'correct' => false,
                    'mark' => 0,
                    'correct_answer' => $question->correct_answer
                ];
            }
        }

        $submission = StudentSubmission::create([
            'student_id' => $student->id,
            'submittable_type' => CourseModuleHomeWork::class,
            'submittable_id' => $id,
            'answers' => $validatedData['answers'],
            'score' => $score,
            'completed' => true,
            'submitted_at' => now(),
            'feedback' => $feedback
        ]);

        // Update course progress
        $courseProgress = CourseProgress::where([
            'student_id' => $student->id,
            'course_id' => $homework->courseModule->course_id
        ])->first();

        if ($courseProgress) {
            $courseProgress->completed_assignments = StudentSubmission::where('student_id', $student->id)
                ->whereIn('submittable_id', $homework->courseModule->course->modules->pluck('courseModuleHomeWorks')->flatten()->pluck('id'))
                ->where('submittable_type', CourseModuleHomeWork::class)
                ->where('completed', true)
                ->count();
            $courseProgress->updateOverallProgress();
            $courseProgress->save();
        }

        return response()->json([
            'success' => true,
            'score' => $score,
            'total_marks' => $totalMarks,
            'feedback' => $feedback
        ]);
    }
}
