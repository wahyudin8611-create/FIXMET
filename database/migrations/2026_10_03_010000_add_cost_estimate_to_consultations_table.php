<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            // Hasil estimasi biaya berbasis AI (tingkat kerusakan, suku cadang,
            // kerumitan, total). Null sampai estimasi pertama dibuat.
            $table->json('cost_estimate')->nullable()->after('visual_evidence');
        });
    }

    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn('cost_estimate');
        });
    }
};
