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
            $table->string('app_name')->default('EXAM BROWSER');
            $table->string('app_logo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apk_configs', function (Blueprint $table) {
            $table->dropColumn(['app_name', 'app_logo']);
        });
    }
};
