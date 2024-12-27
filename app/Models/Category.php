<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory , softDeletes;

    protected $fillable = [
          'name',
          'code',
          'img',
          'status',
          'priority',
          'parent_id',
          'created_by',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function chiled()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

}
