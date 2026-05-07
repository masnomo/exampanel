<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Admin Protected Routes
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', function() { return redirect()->route('dashboard'); });
    Route::post('/admin/kick/{id}', [DashboardController::class, 'kick'])->name('admin.kick');
    Route::post('/admin/unblock/{id}', [DashboardController::class, 'unblock'])->name('admin.unblock');
    Route::post('/admin/message/{id}', [DashboardController::class, 'sendMessage'])->name('admin.message');
    Route::post('/admin/pause/{id}', [DashboardController::class, 'pauseStudent'])->name('admin.pause');
    Route::post('/admin/resume/{id}', [DashboardController::class, 'resumeStudent'])->name('admin.resume');
    Route::post('/admin/freeze-all', [DashboardController::class, 'freezeAll'])->name('admin.freeze-all');
    Route::post('/admin/resume-all', [DashboardController::class, 'resumeAll'])->name('admin.resume-all');
    Route::post('/dashboard/command/{id}', [DashboardController::class, 'sendCommand'])->name('dashboard.command');
    Route::post('/dashboard/refresh-all', [DashboardController::class, 'refreshAll'])->name('dashboard.refresh-all');
    Route::post('/dashboard/reset-all', [DashboardController::class, 'resetAll'])->name('dashboard.reset-all');
    Route::post('/dashboard/toggle-lock', [DashboardController::class, 'toggleExamStatus'])->name('dashboard.toggle-lock');
    Route::post('/settings/update', [DashboardController::class, 'updateSettings'])->name('settings.update');
    Route::post('/admin/config/update', [DashboardController::class, 'updateSettings'])->name('config.update'); 
    Route::get('/stats', [DashboardController::class, 'getStats'])->name('stats');
    Route::post('/admin/rooms', [App\Http\Controllers\RoomController::class, 'store'])->name('rooms.store');
    Route::post('/admin/rooms/delete/{id}', [App\Http\Controllers\RoomController::class, 'destroy'])->name('rooms.destroy');

    Route::get('/admin/settings', function() {
        $config = \App\Models\ApkConfig::first();
        $rooms = \App\Models\ExamRoom::all();
        return view('settings', compact('config', 'rooms'));
    })->name('settings');
    Route::post('/sessions/reset', [DashboardController::class, 'resetSessions'])->name('sessions.reset');

    Route::get('/cheat-logs', [\App\Http\Controllers\CheatLogController::class, 'index'])->name('cheat-logs.index');
    Route::post('/cheat-logs/clear', [\App\Http\Controllers\CheatLogController::class, 'clear'])->name('cheat-logs.clear');

    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/template', [StudentController::class, 'downloadTemplate'])->name('students.template');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::post('/students/import', [StudentController::class, 'import'])->name('students.import');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Fitur Sekali Klik buat Bapak (Auto Migration)
    Route::get('/migrate-database', function() {
        try {
            if (function_exists('opcache_reset')) { opcache_reset(); }
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            \Illuminate\Support\Facades\Artisan::call('view:clear');
            \Illuminate\Support\Facades\Artisan::call('cache:clear');
            \Illuminate\Support\Facades\Artisan::call('config:clear');
            return "<h1>✅ Database, View & OPCache Berhasil Dibersihkan!</h1><p>Sistem sudah 100% segar. Silakan kembali ke <a href='/'>Dashboard</a></p>";
        } catch (\Exception $e) {
            return "<h1>❌ Gagal Menginstal Database</h1><p>Error: " . $e->getMessage() . "</p>";
        }
    });
});
