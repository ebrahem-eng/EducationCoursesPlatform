<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'created_by',
    ];

    public function admin()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'created_by');
    }
}
