<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModelExamQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_model_exam_id',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'mark'
    ];

    public function exam()
    {
        return $this->belongsTo(CourseModelExam::class, 'course_model_exam_id');
    }

    public function courseModelExam()
    {
        return $this->belongsTo(CourseModelExam::class, 'course_model_exam_id');
    }

    
}
