<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('course_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->integer('completed_videos')->default(0);
            $table->integer('completed_assignments')->default(0);
            $table->integer('completed_exams')->default(0);
            $table->float('overall_progress')->default(0); // Percentage of course completion
            $table->timestamps();
            
            $table->unique(['student_id', 'course_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_progress');
    }
}; 