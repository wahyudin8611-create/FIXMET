<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Comma-separated everyday phrases for a symptom (e.g. "retak, pecah"),
     * used to answer it from the user's complaint without asking again.
     */
    public function up(): void
    {
        Schema::table('symptoms', function (Blueprint $table) {
            $table->text('keywords')->nullable()->after('question');
        });
    }

    public function down(): void
    {
        Schema::table('symptoms', function (Blueprint $table) {
            $table->dropColumn('keywords');
        });
    }
};
