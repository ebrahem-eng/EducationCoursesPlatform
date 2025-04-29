<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'status',
        'status_publish',
        'change_status_by',
        'rejected_cause',
        'rejected_by',
        'publish_by',
        'teacher_id',
        'image',
        'duration'
     ];

    public function pyblishedBy()
    {
        return $this->belongsTo(Admin::class, 'publish_by');
    }
     public function changeStatusBy()
     {
         return $this->belongsTo(Admin::class, 'change_status_by');
     }

     public function rejectedBy()
     {
         return $this->belongsTo(Admin::class, 'rejected_by');
     }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function categories()
    {
        return $this->hasMany(CourseCategory::class, 'course_id');
    }

    public function students()
    {
        return $this->hasMany(StudentCourse::class, 'course_id');
    }

    public function courseSkills()
    {
        return $this->hasMany(CourseSkills::class , 'course_id');
    }

    public function modules()
    {
        return $this->hasMany(CourseModule::class, 'course_id');
    }

}
