<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('technicians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('specialization');
            $table->text('description')->nullable();
            $table->string('certificate')->nullable();
            $table->string('identity_card')->nullable();
            $table->string('skill_evidence')->nullable();
            $table->decimal('service_fee', 12, 2)->default(0);
            $table->string('service_area');
            $table->enum('status', ['pending', 'verified', 'rejected', 'suspended'])->default('pending');
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('completed_jobs')->default(0);
            $table->boolean('is_available')->default(true);
            $table->boolean('is_verified')->default(false);
            $table->integer('experience_years')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technicians');
    }
};
