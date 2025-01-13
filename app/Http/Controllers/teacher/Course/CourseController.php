<?php

namespace App\Http\Controllers\teacher\Course;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseCategory;
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

    public function store(Request $request)
    {
        try {
            // Start database transaction
            DB::beginTransaction();

            // Validate the image exists
            if (!$request->hasFile('img')) {
                return redirect()->back()
                    ->withInput()
                    ->with('error_message', 'Please upload a course image');
            }
           $courseExists = Course::where('name' , $request->input('name'))->orWhere('code' , $request->input('code'))->first();
            if($courseExists)
            {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error_message', 'Failed to create course. Course already exists');
            }
            // Handle file upload
            $image = $request->file('img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('CourseImage', $imageName, 'image');

            // Create course
            $course = Course::create([
                'name' => $request->input('name'),
                'code' => $request->input('code'),
                'status' => '0',
                'status_publish' => '0',
                'image' => $path,
                'teacher_id' => Auth::guard('teacher')->user()->id,
            ]);

            // Create main category relation
            CourseCategory::create([
                'course_id' => $course->id,
                'category_id' => $request->input('category'),
            ]);

            // Create subcategories relations
            $subcategories = $request->input('subcategories', []);
            foreach ($subcategories as $subcategoryId) {
                CourseCategory::create([
                    'course_id' => $course->id,
                    'category_id' => $subcategoryId,
                ]);
            }

            // If everything is successful, commit the transaction
            DB::commit();

            return redirect()
                ->route('teacher.course.index')
                ->with('success_message', 'Course Created Successfully');

        }
        catch (\Exception $e) {
            // If any error occurs, roll back the transaction
            DB::rollBack();

            // Log the error for debugging
            \Log::error('Course creation failed: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error_message', 'Failed to create course. Please try again.');
        }
    }
}
