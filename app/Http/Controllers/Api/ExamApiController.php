<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApkConfig;
use App\Models\DeviceSession;
use App\Models\CheatLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ExamApiController extends Controller
{
    /**
     * Login student and return data.
     */
    public function login(Request $request)
    {
        // Log untuk debug
        \Log::info('Percobaan Login - Device: ' . $request->device_id . ' | User: ' . $request->username);

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'device_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Lengkapi data login (termasuk Device ID)'], 400);
        }

        // Cek apakah perangkat diblokir
        $session = DeviceSession::where('device_id', $request->device_id)->first();
        
        if ($session) {
            \Log::info('Status Perangkat di DB: ' . $session->status);
        }

        if ($session && $session->status == 'force_quit') {
            \Log::info('LOGIN DITOLAK: Perangkat terblokir.');
            return response()->json([
                'success' => false, 
                'message' => 'Akses diblokir oleh Pengawas. Silakan hubungi proktor untuk membuka blokir.'
            ], 403);
        }

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = Auth::user();
            
            // Simpan sesi dengan nama lengkap
            DeviceSession::updateOrCreate(
                ['device_id' => $request->device_id],
                [
                    'student_identity' => $request->username,
                    'student_name' => $user->name,
                    'exam_room' => $request->room,
                    'status' => 'active',
                    'last_ping' => now()
                ]
            );

            \Log::info('LOGIN BERHASIL: ' . $user->username);
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'user' => [
                    'name' => $user->name,
                    'username' => $user->username
                ]
            ]);
        }

        \Log::warning('LOGIN GAGAL: Kredensial salah.');
        return response()->json(['success' => false, 'message' => 'Username atau Password salah'], 401);
    }

    /**
     * Get the latest APK configuration.
     */
    public function getConfig()
    {
        $config = ApkConfig::first();
        
        if (!$config) {
            // Default config if none exists
            $config = ApkConfig::create([
                'cbt_url' => 'http://localhost/cbtcoba',
                'exam_status' => 'ready',
                'exit_password' => 'guru123',
                'app_secret_key' => 'ExamBrowser-Official-2026'
            ]);
        }

        $rooms = \App\Models\ExamRoom::where('is_active', true)->pluck('name')->toArray();
        $config->available_rooms = implode(', ', $rooms);

        return response()->json([
            'success' => true,
            'data' => $config
        ]);
    }

    /**
     * Receive heartbeat from APK.
     */
    public function heartbeat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string',
            'student_identity' => 'nullable|string',
            'status' => 'required|in:active,locked,force_quit',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }

        $session = DeviceSession::where('device_id', $request->device_id)->first();
        
        $statusToSave = $request->status;
        // Jika di DB statusnya force_quit atau paused, jangan biarkan HP menimpanya kembali jadi active
        if ($session && in_array($session->status, ['force_quit', 'paused'])) {
            $statusToSave = $session->status;
        }

        $session = DeviceSession::updateOrCreate(
            ['device_id' => $request->device_id],
            [
                'student_identity' => $request->student_identity,
                'student_name' => $request->student_name, // Simpan Nama Lengkap
                'exam_room' => $request->exam_room,
                'status' => $statusToSave,
                'last_ping' => now(),
                'battery_level' => $request->battery_level,
                'wifi_signal' => $request->wifi_signal,
            ]
        );

        $response = [
            'success' => true,
            'message' => 'Heartbeat received',
            'exam_status' => ApkConfig::first()?->exam_status ?? 'ready',
            'session_status' => $session->status,
            'remote_message' => $session->message,
            'command' => $session->command
        ];

        // Clear after delivery
        if ($session->message || $session->command) {
            $session->update(['message' => null, 'command' => null]);
        }

        return response()->json($response);
    }

    public function clearMessage(Request $request)
    {
        $request->validate(['device_id' => 'required|string']);
        DeviceSession::where('device_id', $request->device_id)->update(['message' => null]);
        return response()->json(['success' => true]);
    }

    public function sessionStatus($id, $status)
    {
        $session = DeviceSession::find($id);
        if (!$session) return response()->json(['success' => false, 'message' => 'Sesi tidak ditemukan'], 404);
        
        $session->update(['status' => $status]);
        
        $msg = $status == 'paused' ? 'Layar siswa berhasil dibekukan' : 'Layar siswa berhasil dibuka kembali';
        return response()->json(['success' => true, 'message' => $msg]);
    }

    public function clearCommand(Request $request)
    {
        $request->validate(['device_id' => 'required|string']);
        DeviceSession::where('device_id', $request->device_id)->update(['command' => null]);
        return response()->json(['success' => true]);
    }

    /**
     * Report cheating/violation.
     */
    public function reportCheat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string',
            'violation_type' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 400);
        }

        $log = CheatLog::create([
            'device_id' => $request->device_id,
            'violation_type' => $request->violation_type,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Violation logged'
        ]);
    }
}
