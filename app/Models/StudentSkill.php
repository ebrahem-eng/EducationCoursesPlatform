<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'skill_id',
        'course_id',
        'percentage'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
