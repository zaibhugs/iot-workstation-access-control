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
    Schema::create('pc_access_logs', function (Blueprint $table) {
            $table->id();
            // Event time from C# / ESP
            $table->timestamp('occurred_at');
            // Time received by Laravel
            $table->timestamp('received_at')->useCurrent();
            // Source identifiers
            $table->string('device_uid', 100);
            $table->tinyInteger('pc_port'); // 1 or 2
            $table->string('rfid_uid', 100);
            // Resolved workstation (via device_workstations mapping)
            $table->foreignId('workstation_id')
                ->nullable()
                ->constrained('workstations')
                ->nullOnDelete();
            // Meaning of the event
            $table->string('event_type', 20); // time_in, time_out, denied
            $table->string('result', 10);     // allowed, denied
            $table->string('reason', 100)->nullable();
            // Pairing in/out
            $table->string('session_id', 64)->nullable();
            // Optional snapshot of student API data
            $table->string('student_external_id', 100)->nullable();
            $table->string('student_name', 255)->nullable();
            $table->string('course', 255)->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->index(['device_uid', 'occurred_at']);
            $table->index(['workstation_id', 'occurred_at']);
            $table->index(['rfid_uid', 'occurred_at']);
            $table->index(['session_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pc_access_logs');
    }
};
