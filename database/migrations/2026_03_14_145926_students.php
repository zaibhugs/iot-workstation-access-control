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
        Schema::create('students',function(Blueprint $table){
            $table->BigIncrements('id');
            $table->string('uid',100)->unique('uq_students_uid');
            $table->string('external_student_no',50)
            ->nullable()
            ->unique('uq_students_external_student_no');
            $table->timestamps();
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
