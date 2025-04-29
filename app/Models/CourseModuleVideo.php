<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModuleVideo extends Model
{
    use HasFactory;

    protected $fillable = [
         'course_module_id',
         'name', 
         'description',
         'video_url'
        ];

    public function courseModule()
    {
        return $this->belongsTo(CourseModule::class , 'course_module_id');
    }   
}
