<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSkills extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'skill_id',
        'percentage',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class , 'course_id');
    }

    public function skill() 
    {
        return $this->belongsTo(Skill::class , 'skill_id');
    }

}
