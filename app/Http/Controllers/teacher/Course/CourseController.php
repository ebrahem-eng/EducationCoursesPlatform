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

        $skills = \App\Models\Skill::all();
        return view('Teacher.Course.createSkills', compact('skills'));
    }

    public function storeStep2(Request $request)
    {
        try {
            if (!session()->has('course_step1')) {
                return redirect()->route('teacher.course.create')
                    ->with('error_message', 'Please complete step 1 first');
            }
    
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
                ->route('teacher.course.index')
                ->with('success_message', 'Course Created Successfully');
    
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
}
