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
        Schema::create('workstation_sessions',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedBigInteger('workstation_id');
            $table->unsignedBigInteger('workstation_slot_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('student_snapshot_id');
            $table->dateTime('started_at');
            $table->dateTime('ended_at')->nullable();
            $table->string('end_reason',50)->nullable();
            $table->timestamps();
            $table->index(['workstation_id','started_at'],'ix_sessions_workstation_started');
            $table->index(['workstation_slot_id','started_at'],'ix_sessions_slot_started');
            $table->index(['student_id','started_at'],'ix_sessions_student_started');
            $table->index(['student_snapshot_id','started_at'],'ix_sessions_snapshot_started');
            $table->foreign('workstation_id','fk_sessions_workstation')
            ->references('id')->on('workstations')
            ->restrictOnDelete()
            ->cascadeOnUpdate();

            $table->foreign('workstation_slot_id', 'fk_sessions_slot')
            ->references('id')->on('workstation_slots')
            ->restrictOnDelete()
            ->cascadeOnUpdate();
            
            $table->foreign('student_id', 'fk_sessions_student')
            ->references('id')->on('students')
            ->restrictOnDelete()
            ->cascadeOnUpdate();

            $table->foreign('student_snapshot_id', 'fk_sessions_snapshot')
            ->references('id')->on('student_snapshots')
            ->restrictOnDelete()
            ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workstation_sessions');
    }
};
