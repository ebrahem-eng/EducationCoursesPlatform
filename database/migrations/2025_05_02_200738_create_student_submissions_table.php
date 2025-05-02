<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('student_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->morphs('submittable'); // For both homework and exams
            $table->json('answers');
            $table->float('score')->default(0);
            $table->boolean('completed')->default(false);
            $table->timestamp('submitted_at')->nullable();
            $table->json('feedback')->nullable(); // Store correct/incorrect answers and explanations
            $table->timestamps();
            
            $table->unique(['student_id', 'submittable_type', 'submittable_id'], 'unique_submission');
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_submissions');
    }
}; 