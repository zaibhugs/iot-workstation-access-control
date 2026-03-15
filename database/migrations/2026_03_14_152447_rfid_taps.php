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
        Schema::create('rfid_taps',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->uuid('request_id')
            ->unique('uq_rfid_taps_request_id');

            $table->unsignedBigInteger('workstation_id');
            $table->unsignedBigInteger('workstation_slot_id');

            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('student_snapshot_id');

            $table->unsignedBigInteger('workstation_session_id')->nullable();

            $table->string('tap_type', 30);
            $table->string('rejection_reason', 50)->nullable();
            $table->dateTime('tapped_at');

            $table->timestamps();

            $table->index(['workstation_id', 'tapped_at'], 'ix_rfid_taps_workstation_tapped');
            $table->index(['workstation_slot_id', 'tapped_at'], 'ix_rfid_taps_slot_tapped');
            $table->index(['student_id', 'tapped_at'], 'ix_rfid_taps_student_tapped');
            $table->index(['student_snapshot_id', 'tapped_at'], 'ix_rfid_taps_snapshot_tapped');
            $table->index(['workstation_session_id', 'tapped_at'], 'ix_rfid_taps_session_tapped');

            $table->foreign('workstation_id', 'fk_taps_workstation')
            ->references('id')->on('workstations')
            ->restrictOnDelete()
            ->cascadeOnUpdate();

            $table->foreign('workstation_slot_id', 'fk_taps_slot')
            ->references('id')->on('workstation_slots')
            ->restrictOnDelete()
            ->cascadeOnUpdate();

            $table->foreign('student_id', 'fk_taps_student')
            ->references('id')->on('students')
            ->restrictOnDelete()
            ->cascadeOnUpdate();

            $table->foreign('student_snapshot_id', 'fk_taps_snapshot')
            ->references('id')->on('student_snapshots')
            ->restrictOnDelete()
            ->cascadeOnUpdate();

            $table->foreign('workstation_session_id', 'fk_taps_session')
            ->references('id')->on('workstation_sessions')
            ->nullOnDelete()
            ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfid_taps');
    }
};
