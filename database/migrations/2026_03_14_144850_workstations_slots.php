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
        Schema::create('workstation_slots',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedBigInteger('workstation_id');
            $table->unsignedTinyInteger('slot_no');
            $table->string('label',50)->nullable();
            $table->string('status',30)->default('active');
            $table->timestamps();
            $table->unique(['workstation_id','slot_no'],'uq_workstations_slots_workstation_id');
            $table->index('workstation_id','ix_workstation_slot_workstations_id');
            $table->foreign('workstation_id','fk_slots_workstations')->references('id')->on('workstations')->cascadeOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workstation_slots');
    }
};
