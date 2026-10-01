<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('device_id')->constrained();
            $table->foreignId('diagnosis_id')->nullable()->constrained()->nullOnDelete();
            $table->string('consultation_code')->unique();
            $table->string('device_brand')->nullable();
            $table->string('device_model')->nullable();
            $table->integer('device_age')->nullable();
            $table->text('initial_complaint')->nullable();
            $table->enum('status', ['in_progress', 'completed', 'no_diagnosis'])->default('in_progress');
            $table->text('result')->nullable();
            $table->decimal('confidence', 5, 2)->nullable();
            $table->json('all_diagnoses')->nullable();
            $table->json('visual_evidence')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
