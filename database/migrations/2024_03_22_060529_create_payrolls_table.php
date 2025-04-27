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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->integer('header_id');
            $table->integer('employee_id');
            $table->double('basic_pay',8,2);
            $table->double('allowance',8,2);
            $table->double('health_contribution',8,2);
            $table->double('provident_fund',8,2);
            $table->double('tax',8,2);
            $table->double('adjustment',8,2)->default(0);
            $table->double('deductions',8,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
