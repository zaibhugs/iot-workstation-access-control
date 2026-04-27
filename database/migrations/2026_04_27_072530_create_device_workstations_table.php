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
            Schema::create('device_workstations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')
                ->constrained('devices')
                ->cascadeOnDelete();
            $table->tinyInteger('pc_port'); // 1 or 2 (device "channel" for PC)
            $table->foreignId('workstation_id')
                ->constrained('workstations')
                ->cascadeOnDelete();
            $table->timestamps();
            // One device can map only one workstation per port.
            $table->unique(['device_id', 'pc_port']);
            // One workstation can only be assigned to one device overall (one-time setup).
            $table->unique('workstation_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_workstations');
    }
};
