<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'submittable_type',
        'submittable_id',
        'answers',
        'score',
        'completed',
        'submitted_at',
        'feedback'
    ];

    protected $casts = [
        'answers' => 'array',
        'feedback' => 'array',
        'completed' => 'boolean',
        'submitted_at' => 'datetime'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function submittable()
    {
        return $this->morphTo();
    }

    public function grade()
    {
        $totalScore = 0;
        $feedback = [];
        
        foreach ($this->answers as $questionId => $answer) {
            $question = $this->submittable->questions()->find($questionId);
            
            if (!$question) continue;
            
            if (strtolower($answer) === strtolower($question->correct_answer)) {
                $totalScore += $question->mark;
                $feedback[$questionId] = [
                    'correct' => true,
                    'mark' => $question->mark
                ];
            } else {
                $feedback[$questionId] = [
                    'correct' => false,
                    'mark' => 0,
                    'correct_answer' => $question->correct_answer
                ];
            }
        }

        $this->score = $totalScore;
        $this->feedback = $feedback;
        $this->completed = true;
        $this->save();

        // Update course progress
        $courseProgress = CourseProgress::where([
            'student_id' => $this->student_id,
            'course_id' => $this->getCourseId()
        ])->first();

        if ($courseProgress) {
            if ($this->submittable_type === CourseModuleHomeWork::class) {
                $courseProgress->completed_assignments++;
            } else {
                $courseProgress->completed_exams++;
            }
            $courseProgress->save();
            $courseProgress->calculateProgress();
        }

        return $this->score;
    }

    private function getCourseId()
    {
        if ($this->submittable_type === CourseModuleHomeWork::class) {
            return $this->submittable->courseModule->course_id;
        } else {
            return $this->submittable->module->course_id;
        }
    }
} 