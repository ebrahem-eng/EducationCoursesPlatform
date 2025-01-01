<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'status',
        'status_publish',
        'change_status_by',
        'rejected_cause',
     ];

     public function admin()
     {
         return $this->belongsTo(Admin::class, 'change_status_by');
     }

}
