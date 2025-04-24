<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Authenticatable
{
    use SoftDeletes;
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
        'block',
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
