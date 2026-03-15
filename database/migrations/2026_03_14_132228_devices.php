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
        Schema::create('devices',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('device_uid',100)->unique('uq_device_device_uid');
            $table->string('name')->nullable();
            $table->string('api_token_hash')->nullable()->unique('uq_device_api_token_hash');
            $table->string('status',30)->default('pending'); // pending|active|disabled
            $table->string('firmware_version',50)->nullable();
            $table->string('mac_address',17)->nullable();
            $table->dateTime('first_seen_at')->nullable();
            $table->dateTime('last_seen_at')->nullable();
            $table->string('last_ip',45)->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();

            $table->index('status','ix_devices_status');
            $table->index('last_seen_at','devices_last_seen_at');
            $table->index('approved_by','ix_devices_approved_by');
            });
        }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExist('devices');
    }
};
