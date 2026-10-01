<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repair_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repair_report_id')->constrained()->cascadeOnDelete();
            $table->string('image_path');
            $table->enum('image_type', ['before', 'process', 'after']);
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repair_images');
    }
};
