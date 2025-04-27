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
        Schema::create('leave_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->integer('leave_id');
            $table->date('date');
            $table->string('purpose');
            $table->date('start');
            $table->date('end');
            $table->integer('days');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_transactions');
    }
};
