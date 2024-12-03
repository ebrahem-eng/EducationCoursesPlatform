<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , softDeletes;

    protected $guard = 'admin';

    protected $fillable = [
       'name',
       'email',
       'password',
       'gender',
       'status',
       'age',
       'phone',
       'img',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
