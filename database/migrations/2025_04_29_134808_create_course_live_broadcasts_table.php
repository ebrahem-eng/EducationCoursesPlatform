<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_live_broadcasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('stream_key')->unique(); // Unique key for the broadcast
            $table->string('stream_url'); // URL where students can watch
            $table->string('recorded_url')->nullable(); // URL of saved recording
            $table->enum('status', ['scheduled', 'live', 'ended', 'saved', 'discarded'])->default('scheduled');
            $table->datetime('scheduled_start')->nullable();
            $table->datetime('started_at')->nullable();
            $table->datetime('ended_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_live_broadcasts');
    }
}; 