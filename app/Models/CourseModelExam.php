<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModelExam extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_module_id',
         'name',
         'description', 
         'total_mark'];

    public function questions()
    {
        return $this->hasMany(CourseModelExamQuestion::class, 'course_model_exam_id');
    }

    public function module()
    {
        return $this->belongsTo(CourseModule::class, 'course_module_id');
    }
}
