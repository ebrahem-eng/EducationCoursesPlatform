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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->tinyInteger('status');
            $table->tinyInteger('status_publish');
            $table->foreignId('change_status_by')->nullable()->constrained('admins');
            $table->foreignId('teacher_id')->constrained('teachers');
            $table->foreignId('rejected_by')->nullable()->constrained('admins');
            $table->foreignId('publish_by')->nullable()->constrained('admins');
            $table->string('rejected_cause')->nullable();
            $table->string('image')->nullable();
            $table->integer('duration');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
