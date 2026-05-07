<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Siswa | ExamPanel</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #f1f5f9;
            --card-bg: linear-gradient(145deg, #ffffff, #f8fafc);
            --accent-color: #0284c7;
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
        .logo span { color: var(--accent-color); }
        
        .header-right { display: flex; align-items: center; gap: 2rem; }
        .nav-pill { display: flex; background: rgba(0, 0, 0, 0.05); padding: 0.4rem; border-radius: 1rem; border: 1px solid var(--border-color); gap: 0.5rem; }
        .dark-mode .nav-pill { background: rgba(255, 255, 255, 0.03); }
        .nav-link { padding: 0.5rem 1.25rem; border-radius: 0.75rem; text-decoration: none; font-weight: 600; font-size: 0.875rem; color: var(--text-secondary); display: flex; align-items: center; gap: 0.5rem; transition: 0.3s; }
        .nav-link.active { background: var(--accent-color); color: white; box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3); }
        .nav-link:not(.active):hover { background: rgba(0, 0, 0, 0.03); color: var(--text-primary); }
        .dark-mode .nav-link:not(.active):hover { background: rgba(255, 255, 255, 0.05); }

        .main-grid { display: grid; grid-template-columns: 1fr 300px; gap: 2rem; }
        .panel { background: var(--card-bg); padding: 2rem; border-radius: 1.5rem; border: 1px solid var(--border-color); box-shadow: var(--card-shadow); }
        .panel-title { font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; color: var(--text-secondary); font-size: 0.8rem; text-transform: uppercase; padding-bottom: 1rem; }
        td { padding: 1rem 0; border-top: 1px solid var(--border-color); }

        .btn { padding: 0.75rem 1.5rem; border-radius: 0.75rem; border: none; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; }
        .btn-primary { background: var(--accent-color); color: white; }
        .btn-danger { background: #ef4444; color: white; padding: 0.4rem 0.8rem; font-size: 0.8rem; }
        
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 0.5rem; }
        input { width: 100%; padding: 0.8rem; background: var(--bg-color); border: 1px solid var(--border-color); border-radius: 0.75rem; color: var(--text-primary); }

        .alert { padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }

        /* Modern File Upload */
        .file-upload-wrapper {
            position: relative;
            width: 100%;
            margin-bottom: 1rem;
        }

        .file-upload-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            background: var(--bg-color);
            border: 2px dashed var(--border-color);
            border-radius: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .file-upload-label:hover {
            border-color: var(--accent-color);
            background: rgba(2, 132, 199, 0.05);
        }

        .file-upload-label i { font-size: 1.5rem; margin-bottom: 0.5rem; }
        .file-upload-label span { font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); }
        .file-upload-input { display: none; }
        /* Enhanced Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.active { 
            display: flex; 
            opacity: 1;
        }

        .modal-content {
            background: var(--card-bg);
            padding: 0; /* Remove default padding for header */
            border-radius: 1.5rem;
            width: 480px;
            max-width: 90%;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 70px -10px rgba(0, 0, 0, 0.5);
            position: relative;
            transform: scale(0.9);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            overflow: hidden;
        }

        .modal.active .modal-content {
            transform: scale(1);
        }

        .modal-header {
            background: linear-gradient(to right, var(--accent-color), #0369a1);
            padding: 1.5rem 2rem;
            color: white;
        }

        .modal-header h2 { font-size: 1.25rem; font-weight: 700; }

        .modal-body {
            padding: 2rem;
        }

        .modal-close {
            position: absolute;
            top: 1.25rem;
            right: 1.5rem;
            cursor: pointer;
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.8);
            z-index: 10;
        }
        .modal-close:hover { color: white; }

        .btn-edit { background: rgba(2, 132, 199, 0.1); color: var(--accent-color); padding: 0.4rem 0.8rem; font-size: 0.8rem; margin-right: 0.5rem; border: 1px solid rgba(2, 132, 199, 0.2); }
        .btn-edit:hover { background: var(--accent-color); color: white; }
    </style>
</head>
<body>
    <script>
        if (localStorage.getItem('theme') === 'dark') document.body.classList.add('dark-mode');
        
        function updateFileName(input) {
            const fileName = input.files[0].name;
            document.getElementById('file-name-display').innerText = "Selected: " + fileName;
        }

        function filterStudents() {
            const input = document.getElementById('search-student');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const username = row.cells[0].innerText.toLowerCase();
                const name = row.cells[1].innerText.toLowerCase();
                if (username.includes(filter) || name.includes(filter)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }

        const BASE_URL = "{{ url('/') }}";
        function openEditModal(id, username, name) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-username').value = username;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-password').value = '';
            document.getElementById('edit-form').action = `${BASE_URL}/students/${id}`;
            document.getElementById('edit-modal').style.display = 'flex';
            setTimeout(() => {
                document.getElementById('edit-modal').classList.add('active');
            }, 10);
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.remove('active');
            setTimeout(() => {
                document.getElementById('edit-modal').style.display = 'none';
            }, 300);
        }
    </script>

    <div class="container">
        <header>
            <div class="logo"><h1>{{ $config->panel_name }}</h1></div>
            <div class="header-right">
                <nav class="nav-pill">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <span>📊</span> Monitoring
                    </a>
                    <a href="{{ route('students.index') }}" class="nav-link active">
                        <span>👥</span> Data Siswa
                    </a>
                    <a href="{{ route('cheat-logs.index') }}" class="nav-link">
                        <span>🚨</span> Log Kecurangan
                    </a>
                </nav>
                <div class="admin-info" style="display: flex; align-items: center; gap: 1rem; margin-left: 1rem; padding-left: 1rem; border-left: 1px solid var(--border-color);">
                    <div style="text-align: right;">
                        <div style="font-size: 0.875rem; font-weight: 700;">{{ Auth::user()->name }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-secondary);">Administrator</div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); padding: 0.5rem 1rem;">
                            🚪 Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <div class="main-grid">
            <div class="panel">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <div class="panel-title" style="margin-bottom: 0;">Daftar Siswa Terdaftar</div>
                    <div style="width: 300px; position: relative;">
                        <input type="text" id="search-student" onkeyup="filterStudents()" placeholder="🔍 Cari nama atau username..." style="padding: 0.6rem 1rem; font-size: 0.875rem;">
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Dibuat Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $s)
                        <tr>
                            <td style="font-weight: 700;">{{ $s->username }}</td>
                            <td>{{ $s->name }}</td>
                            <td>{{ $s->created_at->format('d M Y') }}</td>
                            <td style="display: flex; align-items: center;">
                                <button onclick="openEditModal('{{ $s->id }}', '{{ $s->username }}', '{{ $s->name }}')" class="btn btn-edit">Edit</button>
                                <form action="{{ route('students.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="side-panels">
                <div class="panel">
                    <div class="panel-title">Tambah Siswa</div>
                    <form action="{{ route('students.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" required placeholder="misal: siswa01">
                        </div>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" required placeholder="misal: Budi Santoso">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%">Simpan Siswa</button>
                    </form>
                </div>

                <div class="panel" style="margin-top: 1.5rem;">
                    <div class="panel-title">Import CSV</div>
                    <div style="margin-bottom: 1.5rem;">
                        <a href="{{ route('students.template') }}" class="btn" style="display: block; text-align: center; background: rgba(99, 102, 241, 0.1); color: #6366f1; border: 1px solid rgba(99, 102, 241, 0.2); text-decoration: none; font-weight: 700;">
                            📥 Download Template (.csv)
                        </a>
                    </div>
                    <p style="font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 1rem;">
                        <b>Petunjuk:</b> Download template di atas, isi datanya, lalu upload di bawah ini.
                    </p>
                    <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="file-upload-wrapper">
                            <label for="csv_file" class="file-upload-label">
                                <span>📁 Pilih File CSV</span>
                                <div id="file-name-display" class="file-name">Belum ada file</div>
                            </label>
                            <input type="file" id="csv_file" name="csv_file" class="file-upload-input" accept=".csv" required onchange="updateFileName(this)">
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%; background: #10b981;">Proses Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="edit-modal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeEditModal()">&times;</span>
            <div class="modal-header">
                <h2>Edit Data Siswa</h2>
            </div>
            <div class="modal-body">
                <form id="edit-form" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit-id">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" id="edit-username" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" id="edit-name" required>
                    </div>
                    <div class="form-group">
                        <label>Password (Kosongkan jika tidak diganti)</label>
                        <input type="password" name="password" id="edit-password">
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1rem; border-radius: 1rem; margin-top: 1rem;">Update Data Siswa</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
