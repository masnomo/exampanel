<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan | ExamPanel</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --accent-color: #0284c7;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--bg-color); color: var(--text-primary); padding: 1.5rem; }
        .container { max-width: 1200px; margin: 0 auto; }
        
        header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: white; padding: 1rem 2rem; border-radius: 1.5rem; box-shadow: var(--card-shadow); border: 1px solid var(--border-color); }
        .logo h1 { font-size: 1.5rem; font-weight: 800; letter-spacing: -0.05em; }
        .logo span { color: var(--accent-color); }
        
        .nav-pill { display: flex; background: #f1f5f9; padding: 0.4rem; border-radius: 1rem; gap: 0.25rem; }
        .nav-link { padding: 0.5rem 1rem; border-radius: 0.75rem; text-decoration: none; font-weight: 600; font-size: 0.875rem; color: var(--text-secondary); display: flex; align-items: center; gap: 0.5rem; transition: 0.3s; }
        .nav-link.active { background: white; color: var(--accent-color); box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        
        .main-layout { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; }
        .card { background: var(--card-bg); border-radius: 1.5rem; border: 1px solid var(--border-color); box-shadow: var(--card-shadow); overflow: hidden; height: fit-content; }
        .card-header { padding: 1.5rem; border-bottom: 1px solid var(--border-color); background: #fcfcfc; display: flex; align-items: center; gap: 0.75rem; }
        .card-header h2 { font-size: 1.1rem; font-weight: 700; color: var(--text-primary); }
        .card-body { padding: 1.5rem; }

        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.5rem; font-weight: 600; }
        input, select { width: 100%; padding: 0.75rem 1rem; background: #fff; border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-primary); font-size: 0.9rem; outline: none; transition: 0.3s; }
        input:focus, select:focus { border-color: var(--accent-color); ring: 2px solid rgba(2, 132, 199, 0.1); }
        
        .btn { padding: 0.75rem 1.5rem; border-radius: 0.75rem; border: none; cursor: pointer; font-weight: 700; font-size: 0.9rem; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; }
        .btn-primary { background: var(--accent-color); color: white; }
        .btn-primary:hover { background: #0369a1; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(2, 132, 199, 0.3); }
        
        .file-upload { position: relative; border: 2px dashed var(--border-color); border-radius: 1rem; padding: 1.5rem; text-align: center; cursor: pointer; transition: 0.3s; }
        .file-upload:hover { border-color: var(--accent-color); background: #f0f9ff; }
        .file-upload input { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
        .file-upload .icon { font-size: 1.5rem; color: var(--accent-color); margin-bottom: 0.5rem; }
        .file-upload p { font-size: 0.8rem; color: var(--text-secondary); font-weight: 600; }

        .rooms-table { width: 100%; border-collapse: collapse; }
        .rooms-table th { text-align: left; padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border-color); }
        .rooms-table td { padding: 1rem; border-bottom: 1px solid var(--border-color); font-weight: 600; }
        
        .badge-active { background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 2rem; font-size: 0.75rem; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo"><h1>EXAM<span>PANEL</span></h1></div>
            <nav class="nav-pill">
                <a href="{{ route('dashboard') }}" class="nav-link">📊 Monitoring</a>
                <a href="{{ route('students.index') }}" class="nav-link">👥 Siswa</a>
                <a href="{{ route('settings') }}" class="nav-link active">⚙️ Pengaturan</a>
            </nav>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn" style="width: auto; background: #fee2e2; color: #dc2626; padding: 0.5rem 1rem;">🚪 Logout</button>
            </form>
        </header>

        <div class="main-layout">
            <!-- KOLOM KIRI: KONFIGURASI UTAMA -->
            <div class="space-y-6" style="display: flex; flex-direction: column; gap: 1.5rem;">
                
                <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-mobile-alt text-blue-500"></i>
                            <h2>Identitas & Branding APK</h2>
                        </div>
                        <div class="card-body">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                <div class="form-group">
                                    <label>Nama Aplikasi (di APK)</label>
                                    <input type="text" name="app_name" value="{{ $config->app_name }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Nama Panel / Sekolah</label>
                                    <input type="text" name="panel_name" value="{{ $config->panel_name }}" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Ucapan Selamat Datang</label>
                                <input type="text" name="welcome_message" value="{{ $config->welcome_message }}">
                            </div>

                            <div class="form-group">
                                <label>Logo Sekolah (.png/.jpg)</label>
                                <div class="file-upload">
                                    <input type="file" name="app_logo" onchange="this.nextElementSibling.nextElementSibling.innerText = this.files[0].name">
                                    <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                    <p>Klik atau seret logo ke sini</p>
                                    <p class="filename" style="margin-top: 5px; color: var(--accent-color);"></p>
                                </div>
                                @if($config->app_logo)
                                    <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
                                        <img src="{{ asset($config->app_logo) }}" style="height: 35px; border-radius: 5px; border: 1px solid var(--border-color);">
                                        <span style="font-size: 0.75rem; color: var(--text-secondary);">Logo saat ini</span>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Target URL CBT (Halaman Ujian)</label>
                                <input type="url" name="cbt_url" value="{{ $config->cbt_url }}" required placeholder="https://...">
                                <small style="color: var(--text-secondary); display: block; margin-top: 5px;">Gunakan <b>https://</b> untuk menghindari error Mixed Content.</small>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                <div class="form-group">
                                    <label>Status Ujian</label>
                                    <select name="exam_status">
                                        <option value="ready" {{ $config->exam_status == 'ready' ? 'selected' : '' }}>Ready (Siap)</option>
                                        <option value="running" {{ $config->exam_status == 'running' ? 'selected' : '' }}>Running (Mulai)</option>
                                        <option value="locked" {{ $config->exam_status == 'locked' ? 'selected' : '' }}>Locked (Kunci)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Password Keluar APK</label>
                                    <input type="text" name="exit_password" value="{{ $config->exit_password }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Ganti Password Admin</label>
                                <input type="password" name="new_password" placeholder="Kosongkan jika tidak ingin ganti">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> SIMPAN SEMUA PENGATURAN
                            </button>
                        </div>
                    </div>
                </form>

                <!-- MANAJEMEN RUANGAN -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-door-open text-orange-500"></i>
                        <h2>Manajemen Ruangan</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('rooms.store') }}" method="POST" style="margin-bottom: 1.5rem;">
                            @csrf
                            <div style="display: flex; gap: 10px; align-items: flex-end;">
                                <div class="form-group" style="flex: 1; margin-bottom: 0;">
                                    <input type="text" name="name" placeholder="Tambah Ruangan (Contoh: RUANG 01)" required>
                                </div>
                                <button type="submit" class="btn btn-primary" style="width: auto;"><i class="fas fa-plus"></i></button>
                            </div>
                        </form>

                        <table class="rooms-table">
                            <thead>
                                <tr>
                                    <th>Nama Ruangan</th>
                                    <th style="text-align: right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rooms as $room)
                                <tr>
                                    <td><i class="fas fa-map-marker-alt text-blue-400 mr-2"></i> {{ strtoupper($room->name) }}</td>
                                    <td style="text-align: right;">
                                        <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Hapus ruangan ini?')">
                                            @csrf
                                            <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer;"><i class="fas fa-trash"></i> Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: STATS & TOOLS -->
            <div class="space-y-6" style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-info-circle text-slate-500"></i>
                        <h2>Informasi Server</h2>
                    </div>
                    <div class="card-body" style="font-size: 0.85rem; line-height: 1.8;">
                        <div style="display: flex; justify-content: space-between;">
                            <span class="text-secondary">Versi Laravel:</span>
                            <span class="font-bold">v11.x</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span class="text-secondary">PHP Version:</span>
                            <span class="font-bold">{{ PHP_VERSION }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span class="text-secondary">Status SSL:</span>
                            <span class="badge-active">Aktif</span>
                        </div>
                    </div>
                </div>

                <div class="card" style="border-color: #fecaca; background: #fffaf0;">
                    <div class="card-header" style="background: #fee2e2;">
                        <i class="fas fa-exclamation-triangle text-red-500"></i>
                        <h2 style="color: #991b1b;">Zona Bahaya</h2>
                    </div>
                    <div class="card-body">
                        <p style="font-size: 0.75rem; color: #991b1b; margin-bottom: 1rem;">Menghapus data akan membersihkan semua sesi aktif dan log kecurangan siswa secara permanen.</p>
                        <form action="{{ route('sessions.reset') }}" method="POST" onsubmit="return confirm('Hapus semua data monitoring?')">
                            @csrf
                            <button type="submit" class="btn" style="background: #dc2626; color: white;"><i class="fas fa-fire"></i> RESET SEMUA DATA</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
        @endif
        @if($errors->any())
            Swal.fire({ icon: 'error', title: 'Opps!', text: "{{ $errors->first() }}" });
        @endif
    </script>
</body>
</html>
