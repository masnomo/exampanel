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
        Schema::table('apk_configs', function (Blueprint $table) {
            $table->string('panel_name')->default('ExamPanel')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apk_configs', function (Blueprint $table) {
            $table->dropColumn('panel_name');
        });
    }
};
