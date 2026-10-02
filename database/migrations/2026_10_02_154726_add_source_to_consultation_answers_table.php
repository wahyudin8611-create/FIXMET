<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Where an answer came from: the user ("user"), their complaint text
     * ("complaint") or the AI photo analysis ("photo").
     */
    public function up(): void
    {
        Schema::table('consultation_answers', function (Blueprint $table) {
            $table->string('source', 20)->default('user')->after('answer');
        });
    }

    public function down(): void
    {
        Schema::table('consultation_answers', function (Blueprint $table) {
            $table->dropColumn('source');
        });
    }
};
