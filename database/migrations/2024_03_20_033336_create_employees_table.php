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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id',20)->nullable();
            $table->string('name',100);
            $table->string('cid_number',20)->index();
            $table->char('gender',1);
            $table->date('dob');
            $table->string('contact_number',20);
            $table->string('email',50)->unique();
            $table->string('address');
            $table->date('appointment_date');
            $table->integer('department_id');
            $table->integer('designation_id');
            $table->integer('bank_id');
            $table->string('tpn',20);
            $table->string('account_number',50);
            $table->integer('employment_type_id');
            $table->char('flag',1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
