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
        // Bersihkan data sesi lama agar tidak bentrok saat menambah unique key baru
        \DB::table('device_sessions')->truncate();

        Schema::table('device_sessions', function (Blueprint $table) {
            $table->dropUnique('device_sessions_device_id_unique');
            $table->unique('student_identity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('device_sessions', function (Blueprint $table) {
            $table->dropUnique('device_sessions_student_identity_unique');
            $table->unique('device_id');
        });
    }
};
