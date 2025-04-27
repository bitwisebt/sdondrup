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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->char('registration_type',2);
            $table->string('registration_number',20);
            $table->date('registration_date');
            $table->string('cid_number',20);
            $table->string('name','50');
            $table->char('gender','1');
            $table->string('contact_number','10');
            $table->string('email','50');
            $table->string('passport_number','10');
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->char('marital_status',1);
            $table->string('present_address');
            $table->char('status',1)->default('A');
            $table->integer('created_by');
            $table->integer('study_id');
            $table->integer('super_agent_id')->nullable();
            $table->integer('sub_agent_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
