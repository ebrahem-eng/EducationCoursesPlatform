<?php

namespace App\Http\Controllers\admin\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //
    public function publishedCourse()
    {
        $courses = Course :: where('status_publish' ,'=', 1)->get();
        return view('Admin.Course.publishedCourse',compact('courses'));
    }

    public function requestPublishCourse()
    {
        $courses = Course :: where('status_publish' ,'=', 0)->get();
        return view('Admin.Course.requestPublishCourse',compact('courses'));
    }

    public function updateStatus(Request $request, $id)
    {
        $course = Course::findOrFail($id);
    
        $course->status = $request->has('status') ? 1 : 0;
        $course->save();
    
        return redirect()->back()->with('success_message', 'Course status updated successfully!');
    }


    
    public function changePublishedCourse(Request $request, $id)
{
    $course = Course::findOrFail($id);

    $course->status_publish = $request->has('status_publish') ? 1 : 0;
    $course->save();

    if ($course->status_publish == 1) {
        return redirect()->route('admin.course.publishedCourse')->with('success', 'Course has been published successfully!');
    } else {
        return redirect()->back()->with('success_message', 'Course has been unpublished successfully!');
    }
}

public function rejectCourse(Request $request, $id)
{
    $course = Course::findOrFail($id);
    $request->validate([
        'reason' => 'required|string|max:255',
    ]);

    $course->status_publish = 0; 
    $course->rejected_cause = $request->reason; 
    $course->save();

    return redirect()->back()->with('success_message', 'Course has been rejected successfully with a reason!');
}










}
