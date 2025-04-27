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
        Schema::create('payroll_headers', function (Blueprint $table) {
            $table->id();
            $table->string('pay_period');
            $table->date('generate_date');
            $table->date('confirm_date')->nullable();
            $table->date('release_date')->nullable();
            $table->char('flag');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_headers');
    }
};
