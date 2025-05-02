<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseProgress extends Model
{
    protected $table = 'course_progress';
    
    protected $fillable = [
        'student_id',
        'course_id',
        'completed_videos',
        'completed_assignments',
        'completed_exams',
        'overall_progress'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function calculateProgress()
    {
        $course = $this->course;
        
        $totalVideos = $course->modules()->withCount('courseModuleVideos')->get()
            ->sum('course_module_videos_count');
        
        $totalAssignments = $course->modules()->withCount('courseModuleHomeWorks')->get()
            ->sum('course_module_home_works_count');
            
        $totalExams = $course->modules()->withCount('courseModelExams')->get()
            ->sum('course_model_exams_count');
            
        $totalItems = $totalVideos + $totalAssignments + $totalExams;
        
        if ($totalItems === 0) {
            return 0;
        }
        
        $completedItems = $this->completed_videos + $this->completed_assignments + $this->completed_exams;
        
        $this->overall_progress = ($completedItems / $totalItems) * 100;
        $this->save();
        
        return $this->overall_progress;
    }
} 