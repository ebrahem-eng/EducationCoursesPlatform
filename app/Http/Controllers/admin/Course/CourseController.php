<?php

namespace App\Http\Controllers\admin\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    //
    public function publishedCourse()
    {
        $courses = Course::where('status_publish' , 1)->get();
        return view('Admin.Course.publishedCourse',compact('courses'));
    }

    public function requestPublishCourse()
    {
        $courses = Course::where('status_publish', 0)
            ->whereNull('rejected_by')
            ->where(function($query) {
                $query->whereNull('rejected_cause')->orWhere('rejected_cause', '');
            })
            ->get();
        return view('Admin.Course.requestPublishCourse', compact('courses'));
    }

    public function canceledCourse()
    {
        $courses = Course::where('status_publish', 2)
            ->get();
        return view('Admin.Course.canceledCourse', compact('courses'));
    }

    public function updateStatus(Request $request, $id)
    {
        $course = Course::findOrFail($id);
    
        $course->update([
            'status' => $request->has('status') ? 1 : 0,
            'change_status_by' => Auth::guard('admin')->user()->id,
        ]);
    
        return redirect()->back()->with('success_message', 'Course status updated successfully!');
    }


    
    public function changePublishedCourse(Request $request, $id)
{
    $course = Course::findOrFail($id);

    $course->update([
        'status_publish' => $request->has('status_publish') ? 1 : 0,
        'publish_by' => Auth::guard('admin')->user()->id,
    ]);

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
