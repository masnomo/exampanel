<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | ExamPanel</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #f1f5f9;
            --card-bg: #ffffff;
            --accent-color: #0284c7;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-primary);
            font-family: 'Outfit', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            background: var(--card-bg);
            padding: 3rem;
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            border: 1px solid var(--border-color);
        }

        .logo { text-align: center; margin-bottom: 2rem; }
        .logo h1 { font-size: 2rem; font-weight: 800; margin: 0; }
        .logo span { color: var(--accent-color); }

        .form-group { margin-bottom: 1.5rem; }
        label { display: block; font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 0.5rem; font-weight: 600; }
        input {
            width: 100%;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            font-size: 1rem;
            outline: none;
            transition: 0.3s;
        }
        input:focus { border-color: var(--accent-color); box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.1); }

        .btn {
            width: 100%;
            padding: 1rem;
            background: var(--accent-color);
            color: white;
            border: none;
            border-radius: 1rem;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 1rem;
        }
        .btn:hover { background: #0369a1; transform: translateY(-2px); }

        .error { color: #ef4444; font-size: 0.875rem; margin-bottom: 1.5rem; text-align: center; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            <h1>Exam<span>Panel</span></h1>
            <p style="color: var(--text-secondary); font-size: 0.875rem; margin-top: 0.5rem;">Silakan masuk ke panel kontrol</p>
        </div>

        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required autofocus placeholder="admin">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn">MASUK SEKARANG</button>
        </form>
    </div>
</body>
</html>
