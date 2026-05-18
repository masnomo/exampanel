<?php

namespace App\Http\Controllers;

use App\Models\ApkConfig;
use App\Models\DeviceSession;
use App\Models\CheatLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $config = ApkConfig::first();
        if (!$config) {
            $config = ApkConfig::create([
                'cbt_url' => 'http://localhost/cbtcoba',
                'exam_status' => 'ready',
                'exit_password' => 'guru123'
            ]);
        }

        $activeStudents = DeviceSession::where('last_ping', '>=', now()->subSeconds(30))
            ->where('status', '!=', 'force_quit')
            ->count();
        $totalViolations = CheatLog::count();
        
        $sessions = \App\Models\User::where('role', 'student')
            ->leftJoin('device_sessions', 'users.username', '=', 'device_sessions.student_identity')
            ->select(
                'users.username as student_identity',
                'users.name as db_name',
                'device_sessions.id as session_id',
                'device_sessions.device_id',
                'device_sessions.exam_room',
                'device_sessions.status as session_status',
                'device_sessions.command',
                'device_sessions.battery_level',
                'device_sessions.wifi_signal',
                'device_sessions.last_ping'
            )
            ->orderBy('db_name', 'asc')
            ->get();
            
        $logs = CheatLog::orderBy('created_at', 'desc')->limit(10)->get();

        return view('dashboard', compact('config', 'activeStudents', 'totalViolations', 'sessions', 'logs'));
    }

    public function getStats(Request $request)
    {
        $room = $request->room;
        $query = \App\Models\User::where('role', 'student')
            ->leftJoin('device_sessions', 'users.username', '=', 'device_sessions.student_identity')
            ->select(
                'users.username as student_identity',
                'users.name as db_name',
                'device_sessions.id as session_id',
                'device_sessions.device_id',
                'device_sessions.exam_room',
                'device_sessions.status as session_status',
                'device_sessions.command',
                'device_sessions.battery_level',
                'device_sessions.wifi_signal',
                'device_sessions.last_ping'
            );
        
        if ($room && $room !== 'ALL') {
            $query->where('device_sessions.exam_room', $room);
        }

        $activeStudents = DeviceSession::where('last_ping', '>=', now()->subSeconds(30))
            ->where('status', '!=', 'force_quit')
            ->count();
            
        $totalViolations = CheatLog::count(); // Log tetap global
        
        $sessions = $query->orderBy('users.name', 'asc')->get()
            ->map(function($s) {
                // Tentukan status yang solid
                $statusStr = 'BELUM LOGIN';
                if ($s->session_id) {
                    if ($s->session_status === 'force_quit') {
                        $statusStr = 'DIBLOKIR';
                    } elseif ($s->session_status === 'paused') {
                        $statusStr = 'PAUSED';
                    } else {
                        // Cek apakah last_ping masih baru (dalam 30 detik terakhir)
                        $diffInSeconds = $s->last_ping ? now()->diffInSeconds($s->last_ping) : 9999;
                        if ($diffInSeconds <= 30) {
                            $statusStr = 'ONLINE';
                        } else {
                            $statusStr = 'OFFLINE';
                        }
                    }
                }

                return [
                    'id' => $s->session_id,
                    'device_id' => $s->device_id ?? '-',
                    'student_identity' => $s->student_identity,
                    'student_name' => $s->db_name ?? '-',
                    'exam_room' => $s->exam_room ?? '-',
                    'status' => $statusStr,
                    'command' => $s->command,
                    'battery_level' => $s->battery_level ?? 0,
                    'wifi_signal' => $s->wifi_signal ?? '-',
                    'last_ping_raw' => $s->last_ping ? $s->last_ping->toIso8601String() : null,
                ];
            });
            
        $logs = CheatLog::orderBy('created_at', 'desc')->limit(10)->get();
        $config = ApkConfig::first();

        return response()->json([
            'activeStudents' => $activeStudents,
            'totalViolations' => $totalViolations,
            'sessions' => $sessions,
            'logs' => $logs,
            'exam_status' => $config?->exam_status ?? 'ready'
        ]);
    }

    public function settings()
    {
        $config = ApkConfig::first();
        return view('settings', compact('config'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'panel_name' => 'required|string',
            'app_name' => 'required|string',
            'cbt_url' => 'required|url',
            'exam_status' => 'required|in:ready,running,locked',
            'exit_password' => 'required|string',
            'welcome_message' => 'nullable|string',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'new_password' => 'nullable|min:6'
        ]);

        $config = ApkConfig::first();
        $data = [
            'panel_name' => $request->panel_name,
            'app_name' => $request->app_name,
            'cbt_url' => $request->cbt_url,
            'exam_status' => $request->exam_status,
            'exit_password' => $request->exit_password,
            'welcome_message' => $request->welcome_message ?? '',
        ];

        if ($request->hasFile('app_logo')) {
            $image = $request->file('app_logo');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $image->move($destinationPath, $name);
            $data['app_logo'] = asset('/uploads/'.$name);
        }

        $config->update($data);

        if ($request->filled('new_password')) {
            Auth::user()->update([
                'password' => Hash::make($request->new_password)
            ]);
        }

        return back()->with('success', 'Seluruh pengaturan berhasil diperbarui!');
    }

    public function kick($id)
    {
        $session = DeviceSession::findOrFail($id);
        $session->update(['status' => 'force_quit']);
        return back()->with('success', 'Siswa berhasil dikeluarkan paksa!');
    }

    public function unblock($id)
    {
        $session = DeviceSession::findOrFail($id);
        $session->update(['status' => 'active', 'message' => null, 'command' => null]);
        return back()->with('success', 'Blokir siswa berhasil dibuka!');
    }

    public function sendMessage(Request $request, $id)
    {
        $request->validate(['message' => 'required|string']);
        $session = DeviceSession::findOrFail($id);
        $session->update(['message' => $request->message]);
        return back()->with('success', 'Pesan peringatan berhasil dikirim!');
    }

    public function sendCommand(Request $request, $id)
    {
        $request->validate(['command' => 'required|string']);
        $session = DeviceSession::findOrFail($id);
        $session->update(['command' => $request->command]);
        return back()->with('success', 'Perintah berhasil dikirim ke perangkat!');
    }

    public function refreshAll()
    {
        DeviceSession::where('status', 'active')->update(['command' => 'refresh']);
        return back()->with('success', 'Sinyal refresh telah dikirim ke seluruh perangkat aktif!');
    }

    public function resetAll()
    {
        DeviceSession::truncate();
        CheatLog::truncate();
        return back()->with('success', 'Seluruh sesi dan log kecurangan telah dibersihkan!');
    }


    public function toggleExamStatus()
    {
        $config = ApkConfig::first();
        $newStatus = ($config->exam_status == 'running') ? 'ready' : 'running';
        $config->update(['exam_status' => $newStatus]);
        
        $message = $newStatus == 'running' ? 'Seluruh HP Siswa BERHASIL DIKUNCI!' : 'Seluruh HP Siswa BERHASIL DIBUKA!';
        return back()->with('success', $message);
    }

    public function resetSessions()
    {
        DeviceSession::truncate();
        CheatLog::truncate();
        return back()->with('success', 'Data sesi dan log berhasil dibersihkan!');
    }

    public function pauseStudent(Request $request, $id)
    {
        $session = DeviceSession::findOrFail($id);
        $session->update(['status' => 'paused']);
        
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Layar siswa berhasil dibekukan!']);
        }
        return back()->with('success', 'Layar siswa berhasil dibekukan!');
    }

    public function resumeStudent(Request $request, $id)
    {
        $session = DeviceSession::findOrFail($id);
        $session->update(['status' => 'active']);
        
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Layar siswa berhasil dibuka kembali!']);
        }
        return back()->with('success', 'Layar siswa berhasil dibuka kembali!');
    }

    public function freezeAll()
    {
        DeviceSession::where('status', 'active')->update(['status' => 'paused']);
        return back()->with('success', 'SELURUH HP SISWA BERHASIL DIBEKUKAN!');
    }

    public function resumeAll()
    {
        DeviceSession::where('status', 'paused')->update(['status' => 'active']);
        return back()->with('success', 'SELURUH LAYAR SISWA TELAH DIBUKA KEMBALI!');
    }
}
