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
        Schema::create('student_snapshots',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedBigInteger('student_id');
            $table->dateTime('captured_at');
            $table->string('name')->nullable();
            $table->string('course')->nullable();
            $table->json('raw_payload')->nullable();
            $table->timestamps();
            $table->index(['student_id','captured_at'],'ix_student_snapshots_student_captured');
            $table->index(['course','captured_at'],'ix_student_snapshots_course_captured');
            $table->foreign('student_id','fk_student_snapshots_student')
            ->references('id')->on('students')
            ->restrictionOnDelete()
            ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_snapshots');
    }
};
