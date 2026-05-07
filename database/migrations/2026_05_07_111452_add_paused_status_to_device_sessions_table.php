<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Gunakan Raw SQL karena enum di Laravel Blueprint agak tricky untuk modifikasi
        DB::statement("ALTER TABLE device_sessions MODIFY COLUMN status ENUM('active', 'locked', 'force_quit', 'paused') NOT NULL DEFAULT 'active'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE device_sessions MODIFY COLUMN status ENUM('active', 'locked', 'force_quit') NOT NULL DEFAULT 'active'");
    }
};
