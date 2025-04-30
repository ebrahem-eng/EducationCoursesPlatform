<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseChatMessage extends Model
{
    protected $fillable = [
        'course_id',
        'student_id',
        'teacher_id',
        'content',
        'sender_type',
        'is_read'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
} 