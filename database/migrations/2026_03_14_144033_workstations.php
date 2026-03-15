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
        Schema::create('workstations',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('code',50)->unique('uq_workstations_code');
            $table->unsignedBigInteger('device_id')->nullable();
            $table->string('status',30)->default('active');
            $table->timestamps();
            $table->unique('device_id','uq_workstations_device_id');
            $table->foreign('device_id','fk_workstations_device')->references('id')->on('devices')->nullOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workstations');
    }
};
