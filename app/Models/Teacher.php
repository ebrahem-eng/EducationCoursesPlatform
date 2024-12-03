<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Teacher extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable , softDeletes;

    protected $guard = 'teacher';
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

    //علاقة المدرس مع المسؤولين

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
