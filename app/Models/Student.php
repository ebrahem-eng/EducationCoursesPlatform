<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    protected $guard = 'student';
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'age',
        'status',
        'gender',
        'img',
        'created_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function courses()
    {
        return $this->hasMany(StudentCourse::class, 'student_id');
    }
}
