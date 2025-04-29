<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModuleHomeWork extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_module_id', 
        'name', 
        'description', 
        'total_mark'
    ];

    public function questions()
    {
        return $this->hasMany(CourseModuleHomeWorkQuastion::class, 'course_module_home_work_id');
    }

    public function courseModule()
    {
        return $this->belongsTo(CourseModule::class , 'course_module_id');
    }

    
    
}
