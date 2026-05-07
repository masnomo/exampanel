<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Kecurangan | ExamPanel</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #f1f5f9;
            --card-bg: linear-gradient(145deg, #ffffff, #f8fafc);
            --accent-color: #ef4444;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .dark-mode {
            --bg-color: #0f172a;
            --card-bg: #1e293b;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --border-color: #334155;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; transition: 0.3s; }
        body { background-color: var(--bg-color); color: var(--text-primary); padding: 2rem; }
        .container { max-width: 95%; margin: 0 auto; }
        
        header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 2px solid var(--border-color); }
        .logo h1 { font-size: 1.75rem; font-weight: 800; letter-spacing: -0.05em; }
        
        .header-right { display: flex; align-items: center; gap: 2rem; }
        .nav-pill { display: flex; background: rgba(0, 0, 0, 0.05); padding: 0.4rem; border-radius: 1rem; border: 1px solid var(--border-color); gap: 0.5rem; }
        .nav-link { padding: 0.5rem 1.25rem; border-radius: 0.75rem; text-decoration: none; font-weight: 600; font-size: 0.875rem; color: var(--text-secondary); display: flex; align-items: center; gap: 0.5rem; }
        .nav-link.active { background: #0284c7; color: white; box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3); }

        .panel { background: var(--card-bg); padding: 2rem; border-radius: 1.5rem; border: 1px solid var(--border-color); box-shadow: var(--card-shadow); }
        .panel-title { font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; color: var(--text-secondary); font-size: 0.8rem; text-transform: uppercase; padding-bottom: 1rem; }
        td { padding: 1.2rem 0; border-top: 1px solid var(--border-color); }

        .badge { padding: 0.4rem 0.8rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 700; background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); }
        .btn-clear { background: #ef4444; color: white; padding: 0.6rem 1.2rem; border-radius: 0.75rem; text-decoration: none; font-weight: 600; font-size: 0.875rem; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <script>if (localStorage.getItem('theme') === 'dark') document.body.classList.add('dark-mode');</script>
    <div class="container">
        <header>
            <div class="logo"><h1>{{ $config->panel_name }}</h1></div>
            <div class="header-right">
                <nav class="nav-pill">
                    <a href="{{ route('dashboard') }}" class="nav-link"><span>📊</span> Monitoring</a>
                    <a href="{{ route('students.index') }}" class="nav-link"><span>👥</span> Data Siswa</a>
                    <a href="{{ route('cheat-logs.index') }}" class="nav-link active"><span>🚨</span> Log Kecurangan</a>
                    <a href="{{ route('settings') }}" class="nav-link"><span>⚙️</span> Pengaturan</a>
                </nav>
            </div>
        </header>

        <div class="panel">
            <div class="panel-title">
                Daftar Pelanggaran Terdeteksi
                <form action="{{ route('cheat-logs.clear') }}" method="POST" onsubmit="return confirm('Hapus semua log?')">
                    @csrf
                    <button type="submit" class="btn-clear">🧹 Bersihkan Semua Log</button>
                </form>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Device ID / Siswa</th>
                        <th>Jenis Pelanggaran</th>
                        <th>Waktu Kejadian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td style="font-weight: 700;">{{ $log->device_id }}</td>
                        <td><span class="badge">{{ $log->violation_type }}</span></td>
                        <td>{{ $log->created_at->format('d M Y - H:i:s') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 3rem; color: var(--text-secondary);">Tidak ada kecurangan terdeteksi. Aman! ✅</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div style="margin-top: 1.5rem;">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</body>
</html>
