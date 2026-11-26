<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('student_session_limits');
    }

    public function down(): void
    {
        if (Schema::hasTable('student_session_limits')) {
            return;
        }

        Schema::create('student_session_limits', function (Blueprint $table) {
            $table->id();
            $table->string('student_external_id', 64)->unique();
            $table->string('student_name')->nullable();
            $table->boolean('allow_multiple_sessions')->default(false);
            $table->unsignedSmallInteger('max_sessions')->default(1);
            $table->timestamps();
        });
    }
};
