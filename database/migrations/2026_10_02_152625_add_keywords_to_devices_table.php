<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Comma-separated words users typically use for a device (e.g. "hp, handphone, iphone"),
     * used to recognise the device from a free-text complaint.
     */
    public function up(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->text('keywords')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('keywords');
        });
    }
};
