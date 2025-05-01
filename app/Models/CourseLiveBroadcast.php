<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLiveBroadcast extends Model
{
    use HasFactory;

    protected $fillable = [
       'course_id',
       'teacher_id',
        'title',
        'description',
        'scheduled_start',
        'started_at',
        'ended_at',
        'stream_key',
        'stream_url',
        'recorded_url',
        'status',
    ];

    protected $casts = [
        'scheduled_start' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function isLive()
    {
        return $this->status === 'live';
    }

    public function canBeSaved()
    {
        return $this->status === 'ended';
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'scheduled' => '<span class="badge bg-info">Scheduled</span>',
            'live' => '<span class="badge bg-success">Live</span>',
            'ended' => '<span class="badge bg-warning">Ended</span>',
            'saved' => '<span class="badge bg-primary">Saved</span>',
            'discarded' => '<span class="badge bg-danger">Discarded</span>',
            default => '<span class="badge bg-secondary">Unknown</span>'
        };
    }
} 