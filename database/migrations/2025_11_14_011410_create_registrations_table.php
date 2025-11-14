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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('school');
            $table->string('phone', 20);
            $table->string('study_location');
            $table->string('program');
            $table->string('class_level');
            $table->string('permission_letter_path')->nullable();
            $table->string('permission_letter_original_name')->nullable();
            $table->unsignedInteger('sequence_number');
            $table->string('unique_code')->unique();
            $table->string('qr_payload');
            $table->enum('status', ['Daftar', 'Hadir'])->default('Daftar');
            $table->timestamp('attended_at')->nullable();
            $table->timestamps();

            $table->index(['study_location', 'sequence_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
