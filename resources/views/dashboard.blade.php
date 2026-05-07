<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExamPanel | Secure Exam Browser Control</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --success: #059669;
            --danger: #dc2626;
            --warning: #d97706;
            --bg-body: #f1f5f9;
            --bg-card: #ffffff;
            --text-main: #0f172a;
            --text-sub: #475569;
            --border: #e2e8f0;
        }

        /* Fix SweetAlert Click Issue */
        .swal2-container {
            z-index: 9999 !important;
            pointer-events: auto !important;
        }

        .premium-modal {
            border-radius: 1rem !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1) !important;
            background: #ffffff !important;
            border: 1px solid var(--border) !important;
            pointer-events: auto !important;
        }
        
        .premium-confirm-btn {
            border-radius: 0.5rem !important;
            padding: 0.6rem 1.5rem !important;
            font-weight: 700 !important;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            margin: 0;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .dark-mode {
            /* Dark Mode */
            --bg-color: #0f172a;
            --card-bg: #1e293b;
            --header-bg: #1e293b;
            --accent-color: #38bdf8;
            --accent-hover: #0ea5e9;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --border-color: #334155;
            --table-hover: #1e293b;
            --card-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s, box-shadow 0.3s, transform 0.2s;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 2rem;
        }

        .container {
            max-width: 95%;
            margin: 0 auto;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid var(--border-color);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-pill {
            display: flex;
            background: rgba(0, 0, 0, 0.05);
            padding: 0.4rem;
            border-radius: 1rem;
            border: 1px solid var(--border-color);
            gap: 0.5rem;
        }

        .dark-mode .nav-pill {
            background: rgba(255, 255, 255, 0.03);
        }

        .nav-link {
            padding: 0.5rem 1.25rem;
            border-radius: 0.75rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }

        .nav-link.active {
            background: var(--accent-color);
            color: white;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);
        }

        .nav-link:not(.active):hover {
            background: rgba(0, 0, 0, 0.03);
            color: var(--text-primary);
        }

        .dark-mode .nav-link:not(.active):hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .theme-toggle {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 0.6rem 1.2rem;
            border-radius: 0.75rem;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: var(--card-shadow);
        }

        .theme-toggle:hover {
            border-color: var(--accent-color);
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .logo h1 {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.05em;
        }

        .logo span {
            color: var(--accent-color);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: var(--card-bg);
            padding: 2rem;
            border-radius: 1.25rem;
            border: 1px solid var(--border-color);
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--accent-color);
            opacity: 0.3;
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 25px 30px -5px rgba(0, 0, 0, 0.15);
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
        }

        .main-grid {
            display: grid;
            grid-template-columns: 2.5fr 1fr;
            gap: 2rem;
        }

        .panel {
            background: var(--card-bg);
            padding: 2rem;
            border-radius: 1.5rem;
            border: 1px solid var(--border-color);
            box-shadow: var(--card-shadow);
            margin-bottom: 2rem;
        }

        .panel-title {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            color: var(--text-secondary);
            font-size: 0.75rem;
            text-transform: uppercase;
            padding-bottom: 1rem;
        }

        td {
            padding: 1rem 0;
            border-top: 1px solid var(--border-color);
            font-size: 0.875rem;
        }

        .badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success { background: rgba(34, 197, 94, 0.15); color: #16a34a; }
        .badge-warning { background: rgba(245, 158, 11, 0.15); color: #d97706; }
        .badge-danger { background: rgba(239, 68, 68, 0.15); color: #dc2626; }

        .dark-mode .badge-success { background: rgba(34, 197, 94, 0.2); color: #4ade80; }
        .dark-mode .badge-warning { background: rgba(245, 158, 11, 0.2); color: #fbbf24; }
        .dark-mode .badge-danger { background: rgba(239, 68, 68, 0.2); color: #f87171; }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        input, select {
            width: 100%;
            padding: 0.75rem;
            background: var(--bg-color);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            color: var(--text-primary);
            outline: none;
        }

        input:focus {
            border-color: var(--accent-color);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            width: 100%;
        }

        .btn-primary {
            background: var(--accent-color);
            color: var(--bg-color);
        }

        .btn-primary:hover {
            background: var(--accent-hover);
        }

        .btn-danger {
            background: transparent;
            color: var(--danger);
            border: 1px solid var(--danger);
            margin-top: 1rem;
        }

        .btn-danger:hover {
            background: var(--danger);
            color: white;
        }

        /* NEW MODERN STYLES */
        .action-btn {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #475569;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: all 0.2s;
        }

        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-color: #cbd5e1;
            color: #0f172a;
        }

        .btn-warning {
            background: #fffbeb !important;
            color: #92400e !important;
            border-color: #fde68a !important;
        }

        .btn-danger-filled {
            background: #fef2f2 !important;
            color: #991b1b !important;
            border-color: #fee2e2 !important;
        }

        .badge-success {
            background: #f0fdf4 !important;
            color: #166534 !important;
            border: 1px solid #bbf7d0 !important;
        }
        
        .badge-danger {
            background: #fef2f2 !important;
            color: #991b1b !important;
            border: 1px solid #fee2e2 !important;
        }

        /* MODAL STYLES */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.6); 
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            pointer-events: none;
        }

        .modal-overlay[style*="display: flex"] {
            pointer-events: auto; /* Aktif hanya saat muncul */
        }

        .modal-content {
            background: #ffffff;
            padding: 2.5rem;
            border-radius: 1rem;
            width: 90%;
            max-width: 500px;
            border: 1px solid #e2e8f0;
            /* Memberikan Depth / Kedalaman */
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.3), 0 0 0 1px rgba(0,0,0,0.05);
            animation: modalPop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .modal-header h3 {
            margin: 0;
            color: #0f172a;
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .modal-body textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e2e8f0; /* Garis lebih tegas */
            border-radius: 0.75rem;
            margin: 1.5rem 0;
            font-family: inherit;
            font-size: 1rem;
            color: #1e293b;
            transition: border-color 0.2s;
            outline: none;
        }

        .modal-body textarea:focus {
            border-color: var(--primary);
        }

        /* Tombol Kirim dengan Depth */
        .btn-send {
            background: var(--primary);
            color: white;
            font-weight: 700;
            padding: 0.8rem 2rem;
            border-radius: 0.75rem;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.4), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.2s;
        }

        .btn-send:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.5);
        }

        @keyframes modalPop {
            0% { transform: scale(0.9); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .modal-header {
            margin-bottom: 1.5rem;
        }

        .modal-header h2 {
            font-size: 1.25rem;
            font-weight: 800;
        }

        .modal-footer {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.2);
            color: #4ade80;
            border: 1px solid #22c55e;
        }

        @media (max-width: 768px) {
            .main-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <audio id="cheatAlarm" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" preload="auto"></audio>
    <div class="container">
        <header>
            <div class="logo">
                <h1>{{ $config->panel_name }}</h1>
            </div>
            <div class="header-right">
                <nav class="nav-pill">
                    <a href="{{ route('dashboard') }}" class="nav-link active">
                        <span>📊</span> Monitoring
                    </a>
                    <a href="{{ route('students.index') }}" class="nav-link">
                        <span>👥</span> Data Siswa
                    </a>
                    <a href="{{ route('cheat-logs.index') }}" class="nav-link">
                        <span>🚨</span> Log Kecurangan
                    </a>
                    <a href="{{ route('settings') }}" class="nav-link">
                        <span>⚙️</span> Pengaturan
                    </a>
                </nav>
                <div class="admin-info" style="display: flex; align-items: center; gap: 1rem; margin-left: 1rem; padding-left: 1rem; border-left: 1px solid var(--border-color);">
                    <div style="text-align: right;">
                        <div style="font-size: 0.875rem; font-weight: 700;">{{ Auth::user()->name }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-secondary);">Administrator</div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); padding: 0.5rem 1rem; border-radius: 0.75rem; cursor: pointer; font-weight: 600;">🚪 Logout</button>
                    </form>
                </div>
                <button class="theme-toggle" id="theme-toggle">
                    <span id="theme-icon">🌙</span>
                    <span id="theme-text">Dark Mode</span>
                </button>
            </div>
        </header>

        @if(session('success'))
            <div class="alert" style="padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; background: #dcfce7; color: #166534; border: 1px solid #bbf7d0;">
                {{ session('success') }}
            </div>
        @endif

        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 1.8rem; font-weight: 800; color: var(--primary-color);">DASHBOARD MONITORING</h1>
            <p style="color: var(--text-secondary);">Pantau aktivitas siswa secara real-time.</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Siswa Aktif (1m)</div>
                <div class="stat-value" id="stat-active">{{ $activeStudents }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Pelanggaran</div>
                <div class="stat-value" id="stat-violations" style="color: var(--danger)">{{ $totalViolations }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Uptime Sistem</div>
                <div class="stat-value">Online</div>
            </div>
        </div>

        <div class="panel" style="margin-bottom: 2rem; background: rgba(99, 102, 241, 0.05); border: 1px dashed var(--primary);">
            <div class="panel-title" style="margin-bottom: 1rem;">🚀 Kontrol Global (Seluruh Kelas)</div>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <form action="{{ route('dashboard.toggle-lock') }}" method="POST" style="flex: 2; min-width: 250px;" onsubmit="return confirmAction(event, 'Ganti status penguncian seluruh HP?')">
                    @csrf
                    @php $config = \App\Models\ApkConfig::first(); @endphp
                    @if($config && $config->exam_status == 'running')
                    <button type="submit" class="btn" style="background: #10b981; color: white; height: 50px; font-weight: 800; font-size: 1.1rem; width: 100%; margin-bottom: 0.25rem;">
                        🔓 BUKA SEMUA AKSES
                    </button>
                    <small style="display: block; text-align: center; color: var(--text-secondary);">Izinkan siswa menekan tombol keluar (pakai password).</small>
                    @else
                    <button type="submit" class="btn" style="background: #ef4444; color: white; height: 50px; font-weight: 800; font-size: 1.1rem; width: 100%; margin-bottom: 0.25rem;">
                        🔒 KUNCI SEMUA HP (MODE UJIAN)
                    </button>
                    <small style="display: block; text-align: center; color: var(--text-secondary);">Siswa tidak akan bisa menekan tombol keluar APK.</small>
                    @endif
                </form>

                <form action="{{ route('dashboard.refresh-all') }}" method="POST" style="flex: 1; min-width: 200px;" onsubmit="return confirmAction(event, 'Refresh semua HP siswa sekarang?')">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="background: var(--primary); color: white; height: 50px; margin-bottom: 0.25rem; font-weight: 700;">🔄 REFRESH SOAL</button>
                    <small style="display: block; text-align: center; color: var(--text-sub);">Muat ulang halaman web ujian di semua HP.</small>
                </form>
                
                <form action="{{ route('dashboard.reset-all') }}" method="POST" style="flex: 1; min-width: 200px;" onsubmit="return confirmAction(event, 'Hapus semua sesi dan log? Ujian yang berjalan akan terhenti!')">
                    @csrf
                    <button type="submit" class="btn" style="background: var(--text-sub); color: white; height: 50px; margin-bottom: 0.25rem; font-weight: 700;">🧹 BERSIHKAN DAFTAR</button>
                    <small style="display: block; text-align: center; color: var(--text-sub);">Kosongkan monitoring (gunakan jika sesi ujian selesai).</small>
                </form>
            </div>
        </div>

        <div class="main-grid" style="grid-template-columns: 1fr;">
            <div class="panels-container">
                <div class="panel">
                    <div class="panel-title" style="display: flex; justify-content: space-between; align-items: center;">
                        <span>👥 Monitoring Siswa Real-time</span>
                        <div style="display: flex; align-items: center; gap: 10px; background: var(--bg-color); padding: 4px 12px; border-radius: 10px; border: 1px solid var(--border-color); white-space: nowrap;">
                            <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-secondary); display: flex; align-items: center; gap: 4px;">📍 <span style="letter-spacing: 0.5px;">RUANG</span></span>
                            <select id="roomFilter" onchange="updateStats()" style="background: transparent; border: none; outline: none; font-weight: 800; color: var(--accent-color); cursor: pointer; font-size: 0.85rem; padding: 2px 0;">
                                <option value="ALL">SEMUA</option>
                                @foreach(\App\Models\DeviceSession::select('exam_room')->distinct()->whereNotNull('exam_room')->get() as $room)
                                    <option value="{{ $room->exam_room }}">{{ strtoupper($room->exam_room) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Nama Lengkap</th>
                                <th>Ruangan</th>
                                <th>Status</th>
                                <th>Kesehatan Device</th>
                                <th>Aktifitas Terakhir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="sessions-table">
                            @forelse($sessions as $session)
                            <tr>
                                <td style="font-weight: 700; color: var(--text-primary);">{{ $session->student_identity }}</td>
                                <td style="font-weight: 600;">{{ $session->db_name ?? $session->student_name ?? '-' }}</td>
                                <td><span class="badge" style="background: rgba(99, 102, 241, 0.1); color: #6366f1; border: 1px solid rgba(99, 102, 241, 0.2); font-weight: 700;">{{ strtoupper($session->exam_room) }}</span></td>
                                <td>
                                    <span class="badge {{ $session->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                        {{ strtoupper($session->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span title="Baterai">🔋 {{ $session->battery_level }}%</span>
                                        <span title="Sinyal">📡 {{ $session->wifi_signal }}</span>
                                    </div>
                                </td>
                                <td>{{ $session->last_ping->diffForHumans() }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.75rem; align-items: center;">
                                        <button onclick="openMessageModal('{{ $session->id }}', '{{ $session->student_identity }}')" 
                                                class="action-btn btn-warning" title="Kirim Pesan">
                                            <span>💬</span> Pesan
                                        </button>
                                        
                                        @if($session->status == 'force_quit')
                                        <form action="{{ route('admin.unblock', $session->id) }}" method="POST" onsubmit="return confirmAction(event, 'Buka blokir siswa ini?')">
                                            @csrf
                                            <button type="submit" class="action-btn" style="background: #10b981; color: white;" title="Buka Blokir">
                                                <span>🔓</span> Buka Blokir
                                            </button>
                                        </form>
                                        @else
                                        <div style="display: flex; gap: 0.5rem;">
                                            <form action="{{ route('admin.kick', $session->id) }}" method="POST" onsubmit="return confirmAction(event, 'Keluarkan siswa ini?')">
                                                @csrf
                                                <button type="submit" class="action-btn btn-danger-filled" title="Kick Siswa">
                                                    <span>🚫</span> Kick
                                                </button>
                                            </form>

                                            @if($session->command == 'pause')
                                            <form action="{{ route('admin.resume', $session->id) }}" method="POST" onsubmit="return confirmAction(event, 'Buka kembali layar siswa ini?')">
                                                @csrf
                                                <button type="submit" class="action-btn" style="background: #10b981; color: white;" title="Resume Ujian">
                                                    <span>▶️</span> Resume
                                                </button>
                                            </form>
                                            @else
                                            <form action="{{ route('admin.pause', $session->id) }}" method="POST" onsubmit="return confirmAction(event, 'Bekukan layar siswa ini?')">
                                                @csrf
                                                <button type="submit" class="action-btn" style="background: #f59e0b; color: white;" title="Pause Ujian">
                                                    <span>⏸️</span> Pause
                                                </button>
                                            </form>
                                            @endif

                                            <button onclick="sendCommand('{{ $session->id }}', 'clear_cache', 'Hapus cache dan muat ulang HP siswa ini?')" 
                                                    class="action-btn" style="background: #6366f1; color: white;" title="Hapus Cache">
                                                <span>🧹</span> Cache
                                            </button>
                                            <button onclick="sendCommand('{{ $session->id }}', 'force_close', 'Tutup paksa aplikasi di HP siswa ini?')" 
                                                    class="action-btn" style="background: #000; color: white;" title="Tutup APK">
                                                <span>💀</span> Tutup
                                            </button>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 2rem; color: var(--text-secondary);">
                                    Belum ada siswa terhubung.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="panel">
                    <div class="panel-title">Log Kecurangan Terakhir</div>
                    <table>
                        <thead>
                            <tr>
                                <th>Device ID</th>
                                <th>Jenis Pelanggaran</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody id="logs-table">
                            @forelse($logs as $log)
                            <tr>
                                <td style="font-weight: 700;">{{ $log->device_id }}</td>
                                <td><span class="badge badge-danger">{{ $log->violation_type }}</span></td>
                                <td>{{ $log->created_at->format('H:i:s') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 2rem; color: var(--text-secondary);">
                                    Tidak ada pelanggaran tercatat.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PESAN -->
    <div id="messageModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Kirim Pesan ke Siswa</h2>
                <p style="color: var(--text-secondary); font-size: 0.875rem;">Pesan akan muncul sebagai pop-up di HP siswa.</p>
            </div>
            <form id="messageForm" method="POST" onsubmit="closeMessageModal()">
                @csrf
                <div class="modal-body">
                    <textarea name="message" id="messageInput" rows="4" 
                              placeholder="Tulis peringatan di sini..." required></textarea>
                </div>
                <div class="modal-footer" style="display: flex; gap: 1rem;">
                    <button type="button" onclick="closeMessageModal()" class="btn" style="background: #f1f5f9; color: #475569; width: auto; font-weight: 600;">Batal</button>
                    <button type="submit" class="btn-send" style="flex-grow: 1;">Kirim Pesan 🚀</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const BASE_URL = "{{ url('/') }}";
        const themeToggle = document.getElementById('theme-toggle');
        const body = document.body;
        const themeIcon = document.getElementById('theme-icon');
        const themeText = document.getElementById('theme-text');

        // Check for saved theme
        if (localStorage.getItem('theme') === 'dark') {
            body.classList.add('dark-mode');
            themeIcon.innerText = '☀️';
            themeText.innerText = 'Light Mode';
        }

        themeToggle.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            const isDark = body.classList.contains('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            
            themeIcon.innerText = isDark ? '☀️' : '🌙';
            themeText.innerText = isDark ? 'Light Mode' : 'Dark Mode';
        });

        function sendCommand(id, command, text) {
            Swal.fire({
                title: 'Konfirmasi Perintah',
                text: text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal',
                background: document.body.classList.contains('dark-mode') ? '#1e293b' : '#ffffff',
                color: document.body.classList.contains('dark-mode') ? '#f8fafc' : '#0f172a',
                borderRadius: '1.5rem'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `${BASE_URL}/dashboard/command/${id}`;
                    
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    
                    const cmd = document.createElement('input');
                    cmd.type = 'hidden';
                    cmd.name = 'command';
                    cmd.value = command;
                    
                    form.appendChild(csrf);
                    form.appendChild(cmd);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        let lastViolationCount = 0;

        function updateStats() {
            const room = document.getElementById('roomFilter').value;
            fetch(`{{ route('stats') }}?room=${room}`)
                .then(response => response.json())
                .then(data => {
                    // Play Alarm if new violation
                    if (data.totalViolations > lastViolationCount) {
                        document.getElementById('cheatAlarm').play().catch(e => console.log('Audio play failed:', e));
                        lastViolationCount = data.totalViolations;
                    }

                    // Update Counts
                    const activeCount = document.getElementById('stat-active');
                    const violationCount = document.getElementById('stat-violations');
                    if(activeCount) activeCount.innerText = data.activeStudents;
                    if(violationCount) violationCount.innerText = data.totalViolations;

                    // Update Session Table
                    const sessionTable = document.getElementById('sessions-table');
                    if (sessionTable && data.sessions) {
                        sessionTable.innerHTML = data.sessions.map(s => {
                            let actionButtons = '';
                            if (s.status === 'force_quit') {
                                actionButtons = `
                                    <form action="${BASE_URL}/admin/unblock/${s.id}" method="POST" onsubmit="return confirmAction(event, 'Buka blokir siswa ini?')">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="action-btn" style="background: #10b981; color: white;" title="Buka Blokir">
                                            <span>🔓</span> Buka Blokir
                                        </button>
                                    </form>`;
                            } else {
                                let pauseButton = '';
                                if (s.command === 'pause') {
                                    pauseButton = `
                                        <button onclick="ajaxAction('${BASE_URL}/admin/resume/${s.id}', 'Buka kembali layar siswa ini?')" 
                                                class="action-btn" style="background: #10b981; color: white;" title="Resume Ujian">
                                            <span>▶️</span> Resume
                                        </button>`;
                                } else {
                                    pauseButton = `
                                        <button onclick="ajaxAction('${BASE_URL}/admin/pause/${s.id}', 'Bekukan layar siswa ini?')" 
                                                class="action-btn" style="background: #f59e0b; color: white;" title="Pause Ujian">
                                            <span>⏸️</span> Pause
                                        </button>`;
                                }

                                actionButtons = `
                                    <div style="display: flex; gap: 0.5rem;">
                                        <form action="${BASE_URL}/admin/kick/${s.id}" method="POST" onsubmit="return confirmAction(event, 'Keluarkan siswa ini?')">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="action-btn btn-danger-filled" title="Kick Siswa">
                                                <span>🚫</span> Kick
                                            </button>
                                        </form>
                                        ${pauseButton}
                                        <button onclick="sendCommand('${s.id}', 'clear_cache', 'Hapus cache dan muat ulang HP siswa ini?')" 
                                                class="action-btn" style="background: #6366f1; color: white;" title="Bersihkan Data Web (Cache)">
                                            <span>🧹</span> Cache
                                        </button>
                                        <button onclick="sendCommand('${s.id}', 'force_close', 'Tutup paksa aplikasi di HP siswa ini?')" 
                                                class="action-btn" style="background: #000; color: white;" title="Matikan Aplikasi Secara Total">
                                            <span>💀</span> Tutup
                                        </button>
                                    </div>`;
                            }

                            let statusBadge = '';
                            const lastPing = new Date(s.last_ping_raw);
                            const now = new Date();
                            const diffInSeconds = (now - lastPing) / 1000;

                            if (s.status === 'force_quit') {
                                statusBadge = '<span class="badge badge-danger">DIBLOKIR</span>';
                            } else if (s.command === 'pause') {
                                statusBadge = '<span class="badge" style="background: #f59e0b; color: white;">PAUSED</span>';
                            } else if (diffInSeconds > 60) {
                                statusBadge = '<span class="badge" style="background: #eab308; color: white;">OFFLINE / DELAY</span>';
                            } else {
                                statusBadge = '<span class="badge badge-success">ONLINE</span>';
                            }

                            return `
                                <tr>
                                    <td style="font-weight: 700; color: var(--text-primary);">${s.student_identity || 'Unknown'}</td>
                                    <td style="font-weight: 600;">${s.student_name || s.db_name || '-'}</td>
                                    <td><span class="badge" style="background: rgba(99, 102, 241, 0.1); color: #6366f1; border: 1px solid rgba(99, 102, 241, 0.2); font-weight: 700;">${(s.exam_room || '-').toUpperCase()}</span></td>
                                    <td>
                                        ${statusBadge}
                                    </td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <span title="Baterai">🔋 ${s.battery_level}%</span>
                                            <span title="Sinyal">📡 ${s.wifi_signal}</span>
                                        </div>
                                    </td>
                                    <td>Aktif</td>
                                    <td>
                                        <div style="display: flex; gap: 0.75rem; align-items: center;">
                                            <button onclick="openMessageModal('${s.id}', '${s.student_identity}')" 
                                                    class="action-btn btn-warning" title="Kirim Pesan">
                                                <span>💬</span> Pesan
                                            </button>
                                            ${actionButtons}
                                        </div>
                                    </td>
                                </tr>
                            `;
                        }).join('');
                    }

                    // Update Log Table
                    const logTable = document.getElementById('logs-table');
                    if (logTable && data.logs) {
                        logTable.innerHTML = data.logs.map(l => `
                            <tr>
                                <td style="font-weight: 700;">${l.device_id}</td>
                                <td><span class="badge badge-danger">${l.violation_type}</span></td>
                                <td>${new Date(l.created_at).toLocaleTimeString()}</td>
                            </tr>
                        `).join('');
                    }
                })
                .catch(error => console.error('Error fetching stats:', error));
        }

        function openMessageModal(id, name) {
            const titleEl = document.getElementById('modalTitle');
            if (titleEl) titleEl.innerText = `Peringatan: ${name}`;
            
            const formEl = document.getElementById('messageForm');
            if (formEl) formEl.action = `${BASE_URL}/admin/message/${id}`;
            
            const modalEl = document.getElementById('messageModal');
            if (modalEl) modalEl.style.display = 'flex';
            
            const inputEl = document.getElementById('messageInput');
            if (inputEl) inputEl.focus();
        }

        function closeMessageModal() {
            const modalEl = document.getElementById('messageModal');
            if (modalEl) {
                modalEl.style.display = 'none';
            }
        }

        // Modern SweetAlert2 Configuration
        const PremiumToast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#ffffff',
            customClass: {
                popup: 'premium-toast'
            }
        });

        const premiumAlert = (title, text, icon) => {
            return Swal.fire({
                title: title,
                text: text,
                icon: icon,
                background: '#ffffff',
                color: '#1e293b',
                confirmButtonColor: '#4f46e5',
                showClass: { popup: 'animate__animated animate__fadeInUp animate__faster' },
                hideClass: { popup: 'animate__animated animate__fadeOutDown animate__faster' },
                customClass: {
                    popup: 'premium-modal',
                    confirmButton: 'btn-send'
                }
            });
        };

        function ajaxAction(url, message) {
            Swal.fire({
                title: 'Konfirmasi Aksi',
                text: message,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Lakukan',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                background: '#ffffff',
                customClass: {
                    popup: 'premium-modal',
                    confirmButton: 'btn-send'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Gagal mengeksekusi perintah (404/500)');
                        return response.json();
                    })
                    .then(data => {
                        PremiumToast.fire({
                            icon: 'success',
                            title: data.message || 'Berhasil dieksekusi!'
                        });
                        updateStats();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        premiumAlert('Error!', error.message, 'error');
                    });
                }
            });
        }

        function confirmAction(e, message) {
            e.preventDefault();
            const form = e.target.closest('form');
            
            Swal.fire({
                title: 'Konfirmasi Penting',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Saya Yakin!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                background: '#ffffff',
                customClass: {
                    popup: 'premium-modal',
                    confirmButton: 'btn-send'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            return false;
        }

        // Auto-show Laravel success/error messages
        @if(session('success'))
            PremiumToast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif

        @if(session('error'))
            premiumAlert('Gagal!', "{{ session('error') }}", 'error');
        @endif

        // Poll every 5 seconds
        setInterval(updateStats, 5000);
    </script>
</body>
</html>
