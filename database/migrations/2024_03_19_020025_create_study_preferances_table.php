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
        Schema::create('study_preferances', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->integer('preferance');
            $table->integer('study_id');
            $table->integer('university_id');
            $table->string('course_name');
            $table->string('start',20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_preferances');
    }
};
