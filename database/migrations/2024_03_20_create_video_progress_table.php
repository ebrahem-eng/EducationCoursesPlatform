<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('video_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('video_id')->constrained('course_module_videos')->onDelete('cascade');
            $table->boolean('completed')->default(false);
            $table->integer('watch_time')->default(0); // Time in seconds
            $table->timestamp('last_watched_at')->nullable();
            $table->timestamps();
            
            $table->unique(['student_id', 'video_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('video_progress');
    }
}; 