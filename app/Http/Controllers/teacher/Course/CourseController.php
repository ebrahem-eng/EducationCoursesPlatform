<?php

namespace App\Http\Controllers\teacher\Course;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSkills;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\CourseModuleVideo;
use App\Models\Skill;
use App\Models\CourseModule;
use App\Models\CourseModelExam;
use App\Models\CourseModelExamQuestion;
use App\Models\CourseModuleHomeWork;
use App\Models\CourseModuleHomeWorkQuestion;
use App\Models\StudentCourse;
use App\Models\Student;
use App\Models\CourseChatMessage;

class CourseController extends Controller
{
    //

    public function index()
    {
        $courses = Course::where('teacher_id', Auth::guard('teacher')->user()->id)->get();
        return view('Teacher.Course.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('Teacher.Course.create' , compact('categories'));
    }

    public function getSubCategories($id)
    {
        $categoryID = $id;
        $subcategories = Category::where('parent_id', $categoryID)->get();
        return response()->json($subcategories);
    }

    public function storeStep1(Request $request)
    {
        try {
            if (!$request->hasFile('img')) {
                return redirect()->back()
                    ->withInput()
                    ->with('error_message', 'Please upload a course image');
            }
    
            $courseExists = Course::where('name', $request->input('name'))
                ->orWhere('code', $request->input('code'))
                ->first();
    
            if ($courseExists) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error_message', 'Failed to create course. Course already exists');
            }
    
            // Save the uploaded image temporarily
            $image = $request->file('img');
            $tempImageName = time() . '_' . $image->getClientOriginalName();
            $tempPath = $image->storeAs('tempCourseImages', $tempImageName, 'image'); // save to 'storage/app/public/tempCourseImages'
    
            // Store form data (and image path) in session
            $request->session()->put('course_step1', [
                'name' => $request->input('name'),
                'code' => $request->input('code'),
                'duration' => $request->input('duration'),
                'category' => $request->input('category'),
                'subcategories' => $request->input('subcategories', []),
                'image_path' => $tempPath, // Store only the path, not the object
            ]);
    
            return redirect()->route('teacher.course.create.skills');
        } catch (\Exception $e) {
            \Log::error('Course step 1 failed: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error_message', 'Failed to process step 1. Please try again.');
        }
    }
    

    public function createSkills()
    {
        if (!session()->has('course_step1')) {
            return redirect()->route('teacher.course.create')
                ->with('error_message', 'Please complete step 1 first');
        }

        $skills = Skill::all();
        return view('Teacher.Course.createSkills', compact('skills'));
    }

    public function storeStep2(Request $request)
    {
        try {
            DB::beginTransaction();

            $step1Data = session()->get('course_step1');

            // Now retrieve the temp image
            $tempImagePath = $step1Data['image_path'];

            // Move the file from temp to final CourseImage folder
            $newImageName = basename($tempImagePath); // or you can rename if you want
            \Storage::disk('image')->move($tempImagePath, 'CourseImage/' . $newImageName);

            $finalImagePath = 'CourseImage/' . $newImageName;

            // Create course
            $course = Course::create([
                'name' => $step1Data['name'],
                'code' => $step1Data['code'],
                'status' => '0',
                'status_publish' => '0',
                'image' => $finalImagePath,
                'duration' => $step1Data['duration'],
                'teacher_id' => Auth::guard('teacher')->user()->id,
            ]);

            // Create main category relation
            CourseCategory::create([
                'course_id' => $course->id,
                'category_id' => $step1Data['category'],
            ]);

            // Create subcategories relations
            foreach ($step1Data['subcategories'] as $subcategoryId) {
                CourseCategory::create([
                    'course_id' => $course->id,
                    'category_id' => $subcategoryId,
                ]);
            }

            // Store skills
            $skills = $request->input('skills', []);
            $percentages = $request->input('percentages', []);

            foreach ($skills as $index => $skillId) {
                CourseSkills::create([
                    'course_id' => $course->id,
                    'skill_id' => $skillId,
                    'percentage' => $percentages[$index],
                ]);
            }

            DB::commit();

            // Clear the session data
            session()->forget('course_step1');

            return redirect()
                ->route('teacher.course.create.modules', ['course_id' => $course->id])
                ->with('success_message', 'Course details and skills saved successfully. Now let\'s add some modules!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Course creation failed: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error_message', 'Failed to create course. Please try again.');
        }
    }
    

    public function delete($id)
    {
       $courseID = $id;
       $course = Course::where('id', $courseID)->first();

       if($course->status_publish == 1)
       {
         return redirect()->back()->with('error_message', 'Course is already published');
       }

       if(!empty($course->rejected_by) || !empty($course->rejected_cause))
       {
           return redirect()->back()->with('error_message', 'Course rejected cant deleted');
       }

       $course->forceDelete();
       return redirect()->back()->with('success_message', 'Course Deleted Successfully');
    }

    // Module Management Methods
    public function createModules($course_id)
    {
        $course = Course::findOrFail($course_id);
        return view('Teacher.Course.createModules', compact('course'));
    }

    public function storeModules(Request $request)
    {
        try {
            DB::beginTransaction();

            foreach ($request->modules as $moduleData) {
                $module = new \App\Models\CourseModule([
                    'course_id' => $request->course_id,
                    'name' => $moduleData['name'],
                    'description' => $moduleData['description']
                ]);
                $module->save();
            }

            DB::commit();
            return redirect()->route('teacher.course.index')
                           ->with('success_message', 'Modules created successfully. You can now manage content for each module.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error_message', 'Failed to create modules. Please try again.');
        }
    }

    // Video Management Methods
    public function createModuleVideos($module_id)
    {
        $module = CourseModule::findOrFail($module_id);
        $videos = CourseModuleVideo::where('course_module_id', $module_id)->get();
        return view('Teacher.Course.createModuleVideos', compact('module', 'videos'));
    }

    public function storeModuleVideos(Request $request)
    {
        try {
            DB::beginTransaction();
    
            foreach ($request->videos as $key => $videoData) {
                if ($request->hasFile("videos.{$key}.video_file")) {
                    $video = $request->file("videos.{$key}.video_file");
    
                    // Validate video file
                    $request->validate([
                        "videos.{$key}.video_file" => 'required|mimes:mp4,mov,avi|max:524288' // 500MB max
                    ]);
    
                    // Generate unique video name
                    $videoName = time() . '_' . uniqid() . '_' . $video->getClientOriginalName();
    
                    // Store video in 'public/course_videos'
                    $videoPath = $video->storeAs('public/course_videos', $videoName);
    
                    // Save video information in the database
                    CourseModuleVideo::create([
                        'course_module_id' => $request->module_id,
                        'name' => $videoData['name'],
                        'description' => $videoData['description'],
                        'video_url' => str_replace('public/', '', $videoPath) // Save path without 'public/'
                    ]);
                } else {
                    throw new \Exception('Video file is required');
                }
            }
    
            DB::commit();
            
            return redirect()->route('teacher.course.module.videos', ['module_id' => $request->module_id])
                           ->with('success_message', 'Videos added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to add videos: ' . $e->getMessage());
            return redirect()->back()->with('error_message', 'Failed to add videos. Please try again. Error: ' . $e->getMessage());
        }
    }
    
    

    // Exam Management Methods
    public function createModuleExams($module_id)
    {
        try {
            $module = CourseModule::findOrFail($module_id);
            $exams = CourseModelExam::where('course_module_id', $module_id)
                ->with('questions') // Eager load questions
                ->get();
            
            // Get the current exam if exam_id is provided
            $exam = null;
            if (request()->has('exam_id')) {
                $exam = CourseModelExam::findOrFail(request()->exam_id);
            }
            
            return view('Teacher.Course.createModuleExams', compact('module', 'exams', 'exam'));
        } catch (\Exception $e) {
            \Log::error('Error loading module exams: ' . $e->getMessage());
            return redirect()->back()->with('error_message', 'Error loading module exams. Please try again.');
        }
    }

    public function storeModuleExams(Request $request)
    {
        try {
            DB::beginTransaction();

            $exam = new CourseModelExam([
                'course_module_id' => $request->module_id,
                'name' => $request->name,
                'description' => $request->description,
                'total_mark' => $request->total_mark
            ]);
            $exam->save();

            DB::commit();
            
            // Return to the same page with exam data for adding questions
            return redirect()->back()
                           ->with('exam', $exam)
                           ->with('success_message', 'Exam created successfully. Now add questions.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to create exam: ' . $e->getMessage());
            return redirect()->back()->with('error_message', 'Failed to create exam. Please try again. Error: ' . $e->getMessage());
        }
    }

    public function storeExamQuestions(Request $request)
    {
        try {
            DB::beginTransaction();

            foreach ($request->questions as $questionData) {
                $question = new CourseModelExamQuestion([
                    'course_model_exam_id' => $request->exam_id,
                    'question' => $questionData['question'],
                    'option_a' => $questionData['option_a'],
                    'option_b' => $questionData['option_b'],
                    'option_c' => $questionData['option_c'],
                    'option_d' => $questionData['option_d'],
                    'correct_answer' => $questionData['correct_answer'],
                    'mark' => $questionData['mark']
                ]);
                $question->save();
            }

            DB::commit();
            return redirect()->route('teacher.course.module.homework', ['module_id' => $request->module_id])
                           ->with('success_message', 'Exam questions added successfully. Now create homework.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error_message', 'Failed to add exam questions. Please try again.');
        }
    }

    // Homework Management Methods
    public function createModuleHomework($module_id)
    {
        try {
            // First, verify the module exists and belongs to the current teacher
            $module = CourseModule::with('course')->findOrFail($module_id);
            
            // Verify the module belongs to the current teacher
            if ($module->course->teacher_id !== Auth::guard('teacher')->id()) {
                \Log::warning('Teacher attempted to access unauthorized module: ' . $module_id);
                return redirect()->route('teacher.course.index')
                               ->with('error_message', 'You are not authorized to access this module.');
            }

            // Load homeworks with their questions
            $homeworks = CourseModuleHomeWork::where('course_module_id', $module_id)
                ->with('questions')
                ->get();
            
            // Get the current homework if homework_id is provided
            $homework = null;
            if (request()->has('homework_id')) {
                $homework = CourseModuleHomeWork::with('questions')->findOrFail(request()->homework_id);
                
                // Verify the homework belongs to the correct module
                if ($homework->course_module_id != $module_id) {
                    \Log::warning('Homework does not belong to the specified module');
                    return redirect()->route('teacher.course.module.homework', ['module_id' => $module_id])
                                   ->with('error_message', 'Invalid homework selected.');
                }
            }
            
            return view('Teacher.Course.createModuleHomework', compact('module', 'homeworks', 'homework'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Module or homework not found: ' . $e->getMessage());
            return redirect()->route('teacher.course.index')
                           ->with('error_message', 'The specified module was not found.');
                           
        } catch (\Exception $e) {
            \Log::error('Error in createModuleHomework: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('teacher.course.index')
                           ->with('error_message', 'An error occurred while loading the homework page. Please try again.');
        }
    }

    public function storeModuleHomework(Request $request)
    {
        try {
            // Validate the module exists and belongs to the teacher
            $module = CourseModule::with('course')->findOrFail($request->module_id);
            
            if ($module->course->teacher_id !== Auth::guard('teacher')->id()) {
                throw new \Exception('Unauthorized access to module');
            }

            DB::beginTransaction();

            $homework = new CourseModuleHomeWork([
                'course_module_id' => $request->module_id,
                'name' => $request->name,
                'description' => $request->description,
                'total_mark' => $request->total_mark
            ]);
            $homework->save();

            DB::commit();
            
            return redirect()->route('teacher.course.module.homework', ['module_id' => $request->module_id])
                           ->with('success_message', 'Homework created successfully. Now add questions.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            \Log::error('Module not found: ' . $e->getMessage());
            return redirect()->route('teacher.course.index')
                           ->with('error_message', 'The specified module was not found.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to create homework: ' . $e->getMessage());
            return redirect()->route('teacher.course.module.homework', ['module_id' => $request->module_id])
                           ->with('error_message', 'Failed to create homework. Please try again.');
        }
    }

    public function showExamQuestions($exam_id)
    {
        try {
            $exam =   CourseModelExam::with(['questions', 'module'])->findOrFail($exam_id);
            $module = $exam->module;
            $exams =  CourseModelExam::where('course_module_id', $module->id)
                ->with('questions')
                ->get();
            
            // Get existing questions for this exam
            $questions = $exam->questions;
            
            return view('Teacher.Course.createModuleExams', compact('module', 'exams', 'exam', 'questions'));
        } catch (\Exception $e) {
            \Log::error('Error loading exam questions: ' . $e->getMessage());
            return redirect()->back()->with('error_message', 'Error loading exam questions. Please try again.');
        }
    }

    public function editExamQuestion($question_id)
    {
        // try {
            $question = CourseModelExamQuestion::with(['courseModelExam.module'])->findOrFail($question_id);
            
            // Verify the question belongs to the current teacher
            if ($question->courseModelExam->module->course->teacher_id !== Auth::guard('teacher')->id()) {
                throw new \Exception('Unauthorized access to exam question');
            }
            
            return view('Teacher.Course.editExamQuestion', compact('question'));
        // } catch (\Exception $e) {
        //     \Log::error('Error loading exam question: ' . $e->getMessage());
        //     return redirect()->back()->with('error_message', 'Error loading exam question. Please try again.');
        // }
    }

    public function updateExamQuestion(Request $request, $question_id)
    {
        try {
            DB::beginTransaction();
            
            $question = CourseModelExamQuestion::with(['courseModelExam.module'])->findOrFail($question_id);
            
            // Verify the question belongs to the current teacher
            if ($question->courseModelExam->module->course->teacher_id !== Auth::guard('teacher')->id()) {
                throw new \Exception('Unauthorized access to exam question');
            }

            $question->update([
                'question' => $request->question,
                'option_a' => $request->option_a,
                'option_b' => $request->option_b,
                'option_c' => $request->option_c,
                'option_d' => $request->option_d,
                'correct_answer' => $request->correct_answer,
                'mark' => $request->mark
            ]);

            DB::commit();
            
            return redirect()->route('teacher.course.module.exam.questions', ['exam_id' => $question->course_model_exam_id])
                           ->with('success_message', 'Question updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to update exam question: ' . $e->getMessage());
            return redirect()->back()->with('error_message', 'Failed to update question. Please try again.');
        }
    }

    public function deleteExamQuestion($question_id)
    {
        try {
            $question = CourseModelExamQuestion::with(['courseModelExam.module'])->findOrFail($question_id);
            
            // Verify the question belongs to the current teacher
            if ($question->courseModelExam->module->course->teacher_id !== Auth::guard('teacher')->id()) {
                throw new \Exception('Unauthorized access to exam question');
            }

            $exam_id = $question->course_model_exam_id;
            $question->delete();
            
            return redirect()->route('teacher.course.module.exam.questions', ['exam_id' => $exam_id])
                           ->with('success_message', 'Question deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to delete exam question: ' . $e->getMessage());
            return redirect()->back()->with('error_message', 'Failed to delete question. Please try again.');
        }
    }

    public function showHomeworkQuestions($homework_id)
    {
        try {
            $homework = CourseModuleHomeWork::with(['questions', 'courseModule'])->findOrFail($homework_id);
            $module = $homework->courseModule;
            $homeworks = CourseModuleHomeWork::where('course_module_id', $module->id)
                ->with('questions')
                ->get();
            
            // Get existing questions for this homework
            $questions = $homework->questions;
            
            return view('Teacher.Course.createModuleHomework', compact('module', 'homeworks', 'homework', 'questions'));
        } catch (\Exception $e) {
            \Log::error('Error loading homework questions: ' . $e->getMessage());
            return redirect()->back()->with('error_message', 'Error loading homework questions. Please try again.');
        }
    }

    public function storeHomeworkQuestions(Request $request)
    {
        try {
            DB::beginTransaction();

            foreach ($request->questions as $questionData) {
                $question = new CourseModuleHomeWorkQuastion([
                    'course_module_home_work_id' => $request->homework_id,
                    'question' => $questionData['question'],
                    'option_a' => $questionData['option_a'],
                    'option_b' => $questionData['option_b'],
                    'option_c' => $questionData['option_c'],
                    'option_d' => $questionData['option_d'],
                    'correct_answer' => $questionData['correct_answer'],
                    'mark' => $questionData['mark']
                ]);
                $question->save();
            }

            DB::commit();
            
            // Redirect back to the homework page with the module_id
            $homework = CourseModuleHomeWork::findOrFail($request->homework_id);
            return redirect()->route('teacher.course.module.homework', ['module_id' => $homework->course_module_id])
                           ->with('success_message', 'Homework questions added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to add homework questions: ' . $e->getMessage());
            return redirect()->route('teacher.course.index')
                           ->with('error_message', 'Failed to add homework questions. Please try again.');
        }
    }

    // Add methods for homework question management
    public function editHomeworkQuestion($question_id)
    {
        try {
            $question = CourseModuleHomeWorkQuastion::with(['courseModuleHomeWork.courseModule'])->findOrFail($question_id);
            
            // Verify the question belongs to the current teacher
            if ($question->courseModuleHomeWork->courseModule->course->teacher_id !== Auth::guard('teacher')->id()) {
                throw new \Exception('Unauthorized access to homework question');
            }
            
            return view('Teacher.Course.editHomeworkQuestion', compact('question'));
        } catch (\Exception $e) {
            \Log::error('Error loading homework question: ' . $e->getMessage());
            return redirect()->back()->with('error_message', 'Error loading homework question. Please try again.');
        }
    }

    public function updateHomeworkQuestion(Request $request, $question_id)
    {
        try {
            DB::beginTransaction();
            
            $question = CourseModuleHomeWorkQuastion::with(['courseModuleHomeWork.courseModule'])->findOrFail($question_id);
            
            // Verify the question belongs to the current teacher
            if ($question->courseModuleHomeWork->courseModule->course->teacher_id !== Auth::guard('teacher')->id()) {
                throw new \Exception('Unauthorized access to homework question');
            }

            $question->update([
                'question' => $request->question,
                'option_a' => $request->option_a,
                'option_b' => $request->option_b,
                'option_c' => $request->option_c,
                'option_d' => $request->option_d,
                'correct_answer' => $request->correct_answer,
                'mark' => $request->mark
            ]);

            DB::commit();
            
            return redirect()->route('teacher.course.module.homework.questions', ['homework_id' => $question->course_module_home_work_id])
                           ->with('success_message', 'Question updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to update homework question: ' . $e->getMessage());
            return redirect()->back()->with('error_message', 'Failed to update question. Please try again.');
        }
    }

    public function deleteHomeworkQuestion($question_id)
    {
        try {
            $question = CourseModuleHomeWorkQuastion::with(['courseModuleHomeWork.courseModule'])->findOrFail($question_id);
            
            // Verify the question belongs to the current teacher
            if ($question->courseModuleHomeWork->courseModule->course->teacher_id !== Auth::guard('teacher')->id()) {
                throw new \Exception('Unauthorized access to homework question');
            }

            $homework_id = $question->course_module_home_work_id;
            $question->delete();
            
            return redirect()->route('teacher.course.module.homework.questions', ['homework_id' => $homework_id])
                           ->with('success_message', 'Question deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to delete homework question: ' . $e->getMessage());
            return redirect()->back()->with('error_message', 'Failed to delete question. Please try again.');
        }
    }

    public function cancelCourse($id)
    {
        $course = Course::findOrFail($id);
        if ($course->status_publish == 1) {
            return redirect()->back()->with('error_message', 'Course is already published');
        } elseif ($course->status_publish == 2) {
            return redirect()->back()->with('error_message', 'Course is already canceled');
        }
        $course->update([
            'status_publish' => 2,
        ]);
        return redirect()->back()->with('success_message', 'Course cancelled successfully.');
    }

    public function studentsList($course_id)
    {
        $course = Course::findOrFail($course_id);
        
        // Verify the course belongs to the current teacher
        if ($course->teacher_id !== Auth::guard('teacher')->id()) {
            return redirect()->route('teacher.course.index')
                           ->with('error_message', 'You are not authorized to view this course\'s students.');
        }

        $students = StudentCourse::where('course_id', $course_id)
            ->with('student')
            ->paginate(10);

        return view('Teacher.Course.studentsList', compact('course', 'students'));
    }

    public function studentsSearch(Request $request, $course_id)
    {
        $course = Course::findOrFail($course_id);
        
        // Verify the course belongs to the current teacher
        if ($course->teacher_id !== Auth::guard('teacher')->id()) {
            return redirect()->route('teacher.course.index')
                           ->with('error_message', 'You are not authorized to view this course\'s students.');
        }

        $search = $request->input('search');

        $students = StudentCourse::where('course_id', $course_id)
            ->whereHas('student', function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->with('student')
            ->paginate(10);

        return view('Teacher.Course.studentsList', compact('course', 'students'));
    }

    public function chat($course_id, $student_id)
    {
        $course = Course::findOrFail($course_id);
        $student = Student::findOrFail($student_id);
        
        // Verify the course belongs to the current teacher
        if ($course->teacher_id !== Auth::guard('teacher')->id()) {
            return redirect()->route('teacher.course.index')
                           ->with('error_message', 'You are not authorized to access this chat.');
        }

        // Verify the student is enrolled in the course
        $enrollment = StudentCourse::where('course_id', $course_id)
            ->where('student_id', $student_id)
            ->first();

        if (!$enrollment) {
            return redirect()->route('teacher.course.students.list', $course_id)
                           ->with('error_message', 'This student is not enrolled in this course.');
        }

        // Get chat messages
        $messages = CourseChatMessage::where('course_id', $course_id)
            ->where('student_id', $student_id)
            ->where('teacher_id', Auth::guard('teacher')->id())
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark unread messages as read
        CourseChatMessage::where('course_id', $course_id)
            ->where('student_id', $student_id)
            ->where('teacher_id', Auth::guard('teacher')->id())
            ->where('sender_type', 'student')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('Teacher.Course.chat', compact('course', 'student', 'messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'student_id' => 'required|exists:students,id',
            'message' => 'required|string'
        ]);

        $course = Course::findOrFail($request->course_id);
        
        // Verify the course belongs to the current teacher
        if ($course->teacher_id !== Auth::guard('teacher')->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to send messages in this course.'
            ], 403);
        }

        // Create the message
        $message = CourseChatMessage::create([
            'course_id' => $request->course_id,
            'student_id' => $request->student_id,
            'teacher_id' => Auth::guard('teacher')->id(),
            'content' => $request->message,
            'sender_type' => 'teacher',
            'is_read' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'content' => $message->content,
                'sender_type' => 'teacher',
                'created_at' => $message->created_at->format('M d, Y H:i')
            ]
        ]);
    }
}
