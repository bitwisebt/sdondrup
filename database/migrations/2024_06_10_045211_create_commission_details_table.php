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
        Schema::create('commission_details', function (Blueprint $table) {
            $table->id();
            $table->integer('commission_id');
            $table->integer('commission_type_id');
            $table->integer('student_id');
            $table->double('rate',8,2);
            $table->double('percentage',8,2);
            $table->double('amount',8,2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_details');
    }
};
