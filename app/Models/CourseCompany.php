<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'company_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class , 'course_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class , 'company_id');
    }
    
    
}
