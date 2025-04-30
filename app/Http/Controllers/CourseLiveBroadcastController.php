<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseLiveBroadcast;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CourseLiveBroadcastController extends Controller
{
    // Teacher methods
    public function showBroadcastPage(Course $course)
    {
        $broadcast = $course->liveBroadcasts()
            ->whereIn('status', ['scheduled', 'live'])
            ->latest()
            ->first();

        return view('Teacher.Course.broadcast', compact('course', 'broadcast'));
    }

    public function scheduleBroadcast(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_start' => 'required|date|after:now',
        ]);

        $broadcast = new CourseLiveBroadcast([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'scheduled_start' => $validated['scheduled_start'],
            'stream_key' => Str::random(32),
            'stream_url' => config('broadcasting.stream_url_prefix', 'rtmp://streaming-server.com/live') . '/' . Str::random(32),
            'status' => 'scheduled',
            'course_id' => $course->id,
            'teacher_id' => Auth::guard('teacher')->user()->id,
        ]);

        $broadcast->save();

        return redirect()->route('teacher.course.broadcast', $course)
            ->with('success', 'Broadcast scheduled successfully');
    }

    public function startBroadcast(Course $course, CourseLiveBroadcast $broadcast)
    {
        if ($broadcast->status !== 'scheduled') {
            return back()->with('error', 'This broadcast cannot be started');
        }

        $broadcast->update([
            'status' => 'live',
            'started_at' => now(),
        ]);

        return back()->with('success', 'Broadcast started successfully');
    }

    public function endBroadcast(Course $course, CourseLiveBroadcast $broadcast)
    {
        if ($broadcast->status !== 'live') {
            return back()->with('error', 'This broadcast is not live');
        }

        $broadcast->update([
            'status' => 'ended',
            'ended_at' => now(),
        ]);

        // Delete the broadcast after ending it
        $broadcast->delete();

        return redirect()->route('teacher.course.broadcast', $course)
            ->with('success', 'Broadcast ended successfully');
    }

    // Student methods
    public function watchBroadcast(Course $course, CourseLiveBroadcast $broadcast)
    {
        if (!in_array($broadcast->status, ['scheduled', 'live'])) {
            return back()->with('error', 'This broadcast is not available');
        }

        return view('Student.Course.watch-broadcast', compact('course', 'broadcast'));
    }

    public function getBroadcastStatus(Course $course, CourseLiveBroadcast $broadcast)
    {
        return response()->json([
            'status' => $broadcast->status,
        ]);
    }
} 