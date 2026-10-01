<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Allow consultations without an account and give every consultation an
     * unguessable access token used in its public URL.
     */
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
            $table->string('access_token', 64)->nullable()->unique()->after('consultation_code');
        });

        DB::table('consultations')->whereNull('access_token')->lazyById()->each(function (object $consultation): void {
            DB::table('consultations')
                ->where('id', $consultation->id)
                ->update(['access_token' => Str::random(40)]);
        });
    }

    /**
     * Guest consultations cannot exist in the previous schema, so they are
     * deleted before user_id becomes required again.
     */
    public function down(): void
    {
        DB::table('consultations')->whereNull('user_id')->delete();

        Schema::table('consultations', function (Blueprint $table) {
            $table->dropUnique(['access_token']);
            $table->dropColumn('access_token');
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
