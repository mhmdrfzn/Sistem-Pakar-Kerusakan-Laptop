<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login — LaptopExpert AI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .login-glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
        }
        .login-card {
            position: relative;
            z-index: 1;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.09);
            border-radius: 1.5rem;
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            box-shadow: 0 32px 64px rgba(0,0,0,0.4), 0 0 0 1px rgba(255,255,255,0.05) inset;
        }
        .login-input {
            width: 100%;
            padding: 0.75rem 1rem;
            padding-left: 2.75rem;
            border-radius: 0.75rem;
            font-size: 0.9rem;
            color: #e2e8f0;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            outline: none;
            transition: all 0.2s;
        }
        .login-input:focus {
            border-color: rgba(99,102,241,0.6);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
            background: rgba(255,255,255,0.07);
        }
        .login-input::placeholder { color: #334155; }
        .login-btn {
            width: 100%;
            padding: 0.875rem;
            border-radius: 0.75rem;
            font-size: 0.925rem;
            font-weight: 600;
            color: white;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            border: none;
            cursor: pointer;
            transition: all 0.25s;
            position: relative;
            overflow: hidden;
        }
        .login-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            opacity: 0;
            transition: opacity 0.25s;
        }
        .login-btn:hover::before { opacity: 1; }
        .login-btn:hover { transform: translateY(-1px); box-shadow: 0 12px 28px rgba(99,102,241,0.4); }
        .login-btn:active { transform: translateY(0); }
        .login-btn span { position: relative; z-index: 1; }
        .error-shake {
            animation: shake 0.4s ease;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-6px); }
            40% { transform: translateX(6px); }
            60% { transform: translateX(-4px); }
            80% { transform: translateX(4px); }
        }
        .input-icon {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #475569;
            pointer-events: none;
        }
        .eye-btn {
            position: absolute;
            right: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #475569;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            transition: color 0.2s;
        }
        .eye-btn:hover { color: #94a3b8; }
    </style>
</head>
<body style="background-color: #060610; min-height: 100vh; display: flex; align-items: center; justify-content: center; overflow: hidden;">

    <!-- Background glows -->
    <div class="login-glow" style="width: 500px; height: 500px; background: rgba(79,70,229,0.15); top: -100px; left: -100px;"></div>
    <div class="login-glow" style="width: 400px; height: 400px; background: rgba(124,58,237,0.12); bottom: -80px; right: -80px;"></div>
    <div class="login-glow" style="width: 300px; height: 300px; background: rgba(236,72,153,0.08); top: 50%; left: 60%;"></div>

    <!-- Animated grid background -->
    <div style="position: fixed; inset: 0; background-image: linear-gradient(rgba(99,102,241,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(99,102,241,0.03) 1px, transparent 1px); background-size: 50px 50px; z-index: 0;"></div>

    <div class="w-full max-w-md px-4" style="position: relative; z-index: 1;">

        <!-- Logo + Title -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-5"
                 style="background: linear-gradient(135deg, #4f46e5, #7c3aed); box-shadow: 0 16px 40px rgba(99,102,241,0.4);">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
            <h1 class="font-display font-bold text-2xl text-white mb-2">Admin Panel</h1>
            <p class="text-slate-500 text-sm">LaptopExpert AI — Sistem Pakar Diagnosa Laptop</p>
        </div>

        <!-- Login Card -->
        <div class="login-card p-8">

            <!-- Flash error dari redirect -->
            @if(session('error'))
            <div class="mb-6 p-3.5 rounded-xl flex items-center gap-3 text-sm error-shake"
                 style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25);">
                <svg class="flex-shrink-0 text-red-400" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/>
                </svg>
                <span class="text-red-300">{{ session('error') }}</span>
            </div>
            @endif

            @if(session('success'))
            <div class="mb-6 p-3.5 rounded-xl flex items-center gap-3 text-sm"
                 style="background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.25);">
                <svg class="flex-shrink-0 text-green-400" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                <span class="text-green-300">{{ session('success') }}</span>
            </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" id="login-form">
                @csrf

                <!-- Garis atas -->
                <div class="mb-6 pb-5 border-b" style="border-color: rgba(255,255,255,0.06);">
                    <h2 class="font-semibold text-white text-lg">Masuk ke Admin Panel</h2>
                    <p class="text-slate-500 text-xs mt-1">Masukkan kredensial untuk melanjutkan.</p>
                </div>

                <!-- Username -->
                <div class="mb-4">
                    <label class="block text-xs font-medium text-slate-400 mb-2">Username</label>
                    <div class="relative">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/>
                            </svg>
                        </span>
                        <input type="text" name="username" id="username"
                               value="{{ old('username') }}"
                               placeholder="Masukkan username"
                               autocomplete="username"
                               class="login-input {{ $errors->has('username') || $errors->has('password') ? 'border-red-500/50' : '' }}">
                    </div>
                    @error('username')
                    <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-xs font-medium text-slate-400 mb-2">Password</label>
                    <div class="relative">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </span>
                        <input type="password" name="password" id="password"
                               placeholder="Masukkan password"
                               autocomplete="current-password"
                               class="login-input {{ $errors->has('password') ? 'border-red-500/50 error-shake' : '' }}">
                        <button type="button" class="eye-btn" onclick="togglePassword()" id="eye-btn">
                            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                    <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit" class="login-btn" id="submit-btn">
                    <span class="inline-flex items-center justify-center gap-2">
                        <svg id="btn-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                            <polyline points="10 17 15 12 10 7"/>
                            <line x1="15" x2="3" y1="12" y2="12"/>
                        </svg>
                        <span id="btn-text">Masuk ke Admin Panel</span>
                    </span>
                </button>
            </form>

            <!-- Divider -->
            <div class="flex items-center gap-3 mt-6 mb-5">
                <div class="flex-1 h-px" style="background: rgba(255,255,255,0.06);"></div>
                <span class="text-xs text-slate-600">atau</span>
                <div class="flex-1 h-px" style="background: rgba(255,255,255,0.06);"></div>
            </div>

            <!-- Back to site -->
            <a href="{{ route('home') }}" class="flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm text-slate-500 hover:text-white transition-all"
               style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07);">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Kembali ke Situs Utama
            </a>
        </div>

        <!-- Default credentials hint -->
        <div class="mt-5 text-center">
            <p class="text-slate-700 text-xs">
                Default: <code class="text-slate-500">admin</code> / <code class="text-slate-500">admin123</code>
                <span class="text-slate-700 mx-1">·</span>
                Ubah di <code class="text-slate-500">.env</code>
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.innerHTML = isHidden
                ? `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" x2="23" y1="1" y2="23"/>`
                : `<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>`;
        }

        document.getElementById('login-form').addEventListener('submit', function () {
            const btn = document.getElementById('submit-btn');
            const text = document.getElementById('btn-text');
            const icon = document.getElementById('btn-icon');
            btn.disabled = true;
            text.textContent = 'Memproses...';
            icon.innerHTML = `<path d="M12 2v4"/><path d="m16.2 7.8 2.9-2.9"/><path d="M18 12h4"/><path d="m16.2 16.2 2.9 2.9"/><path d="M12 18v4"/><path d="m4.9 19.1 2.9-2.9"/><path d="M2 12h4"/><path d="m4.9 4.9 2.9 2.9"/>`;
            icon.style.animation = 'spin 1s linear infinite';
        });
    </script>

    <style>
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    </style>

</body>
</html>
