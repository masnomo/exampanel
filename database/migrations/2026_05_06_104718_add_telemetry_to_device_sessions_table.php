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
        Schema::table('device_sessions', function (Blueprint $table) {
            $table->integer('battery_level')->nullable();
            $table->string('wifi_signal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('device_sessions', function (Blueprint $table) {
            $table->dropColumn(['battery_level', 'wifi_signal']);
        });
    }
};
