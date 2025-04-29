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
        Schema::create('course_module_home_work_quastions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_module_home_work_id');
            $table->foreign('course_module_home_work_id', 'homework_question_fk')
                  ->references('id')
                  ->on('course_module_home_works')
                  ->onDelete('cascade');
            $table->string('question');
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');
            $table->enum('correct_answer', ['a', 'b', 'c', 'd']);
            $table->double('mark');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_module_home_work_quastions');
    }
};
