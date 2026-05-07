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
        // 1. Tabel apk_configs
        Schema::create('apk_configs', function (Blueprint $table) {
            $table->id();
            $table->string('cbt_url')->nullable();
            $table->enum('exam_status', ['ready', 'running', 'locked'])->default('ready');
            $table->string('exit_password')->default('guru123');
            $table->string('app_secret_key')->default('ExamBrowser-Official-2026'); // Secret Key tambahan
            $table->timestamps();
        });

        // 2. Tabel device_sessions
        Schema::create('device_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('device_id')->unique();
            $table->string('student_identity')->nullable();
            $table->enum('status', ['active', 'locked', 'force_quit'])->default('active');
            $table->timestamp('last_ping')->nullable();
            $table->timestamps();
        });

        // 3. Tabel cheat_logs
        Schema::create('cheat_logs', function (Blueprint $table) {
            $table->id();
            $table->string('device_id');
            $table->string('violation_type'); // Misal: "Percobaan Screenshot"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apk_configs');
        Schema::dropIfExists('device_sessions');
        Schema::dropIfExists('cheat_logs');
    }
};
