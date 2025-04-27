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
        Schema::create('voucher_headers', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->integer('voucher_type_id');
            $table->date('date');
            $table->string('voucher_number',10);
            $table->string('referance');
            $table->string('description');
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
        Schema::dropIfExists('voucher_headers');
    }
};
