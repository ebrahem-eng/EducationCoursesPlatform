<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModuleHomeWorkQuastion extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_module_home_work_id',
         'question',
          'option_a', 
          'option_b', 
          'option_c', 
          'option_d', 
          'correct_answer', 
          'mark'
        ];

    public function courseModuleHomeWork()
    {
        return $this->belongsTo(CourseModuleHomeWork::class , 'course_module_home_work_id');
    }
}
