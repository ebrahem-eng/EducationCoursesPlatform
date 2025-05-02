<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoProgress extends Model
{
    protected $fillable = [
        'student_id',
        'video_id',
        'completed',
        'watch_time',
        'last_watched_at'
    ];

    protected $casts = [
        'completed' => 'boolean',
        'last_watched_at' => 'datetime'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function video()
    {
        return $this->belongsTo(CourseModuleVideo::class, 'video_id');
    }

    public function markAsCompleted()
    {
        if (!$this->completed) {
            $this->completed = true;
            $this->save();

            // Update course progress
            $courseProgress = CourseProgress::where([
                'student_id' => $this->student_id,
                'course_id' => $this->video->courseModule->course_id
            ])->first();

            if ($courseProgress) {
                $courseProgress->completed_videos++;
                $courseProgress->save();
                $courseProgress->calculateProgress();
            }
        }
    }
} 