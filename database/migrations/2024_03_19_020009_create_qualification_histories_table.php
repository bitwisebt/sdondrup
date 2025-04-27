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
        Schema::create('qualification_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->integer('qualification_id');
            $table->string('school_name');
            $table->string('course_name');
            $table->year('completion_year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qualification_histories');
    }
};
