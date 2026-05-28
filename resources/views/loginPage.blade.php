@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="login-shell">
        <div class="login-panel">
            <div class="login-hero">
                <div class="brand-mark">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <p class="eyebrow">PSU Student Portal</p>
                <h1>Welcome back</h1>
                <p class="hero-copy">Sign in to manage students, teachers, and academic records.</p>

                <div class="hero-points">
                    <div><i class="fas fa-shield-halved"></i><span>Secure access</span></div>
                    <div><i class="fas fa-mobile-screen-button"></i><span>Clean mobile layout</span></div>
                    <div><i class="fas fa-bolt"></i><span>Fast sign-in</span></div>
                </div>
            </div>

            <div class="login-card">
                <div class="login-header">
                    <h2>Login</h2>
                    <p>Use your account credentials to continue.</p>
                </div>

                @if (isset($msg) || $errors->any())
                    <div class="alert alert-danger alert-compact" role="alert">
                        <div class="alert-title">
                            <i class="fas fa-circle-exclamation"></i> Login failed
                        </div>
                        @if (isset($msg))
                            {{ $msg }}
                        @else
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        @endif
                    </div>
                @endif

                <form action="/login" method="POST" autocomplete="off" class="login-form">
                    @csrf

                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input
                                type="text"
                                class="form-control @error('username') is-invalid @enderror"
                                name="username"
                                id="username"
                                placeholder="Enter your username"
                                autocomplete="off"
                                readonly
                                required
                                autofocus>
                        </div>
                        @error('username')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrapper password-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password"
                                id="password"
                                placeholder="Enter your password"
                                autocomplete="new-password"
                                readonly
                                required>
                            <button type="button" class="password-toggle" id="togglePassword" aria-label="Toggle password visibility">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <label class="remember-row">
                        <input type="checkbox" class="form-check-input" name="remember">
                        <span>Remember me</span>
                    </label>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-right-to-bracket"></i>
                        Sign in
                    </button>

                    <p class="login-footer">Need access? Ask your administrator to create your account.</p>
                </form>
            </div>
        </div>
    </div>

    <style>
        .login-shell {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.14), transparent 35%),
                linear-gradient(135deg, #eff6ff 0%, #f8fbff 45%, #ffffff 100%);
        }

        .login-panel {
            width: min(1040px, 100%);
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 1.5rem;
            align-items: stretch;
        }

        .login-hero,
        .login-card {
            border-radius: 24px;
            border: 1px solid rgba(37, 99, 235, 0.12);
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
        }

        .login-hero {
            background: linear-gradient(160deg, #1d4ed8 0%, #2563eb 40%, #0f172a 100%);
            color: #fff;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-hero::after {
            content: '';
            position: absolute;
            inset: auto -40px -60px auto;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            filter: blur(4px);
        }

        .brand-mark {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.14);
            display: grid;
            place-items: center;
            font-size: 1.6rem;
            margin-bottom: 1.25rem;
            backdrop-filter: blur(8px);
        }

        .eyebrow {
            text-transform: uppercase;
            letter-spacing: .12em;
            font-size: .74rem;
            font-weight: 700;
            opacity: .8;
            margin-bottom: .75rem;
        }

        .login-hero h1 {
            font-size: clamp(2rem, 3vw, 3rem);
            line-height: 1.05;
            margin: 0 0 .75rem;
            letter-spacing: -.03em;
        }

        .hero-copy {
            max-width: 32rem;
            font-size: 1rem;
            line-height: 1.7;
            color: rgba(255, 255, 255, .82);
            margin: 0 0 1.75rem;
        }

        .hero-points {
            display: grid;
            gap: .8rem;
            position: relative;
            z-index: 1;
        }

        .hero-points div {
            display: flex;
            align-items: center;
            gap: .75rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .92);
        }

        .hero-points i {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            background: rgba(255, 255, 255, .14);
        }

        .login-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(14px);
            padding: 2.5rem;
        }

        .login-header {
            margin-bottom: 1.4rem;
        }

        .login-header h2 {
            font-size: 1.8rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 .35rem;
            letter-spacing: -.03em;
        }

        .login-header p {
            color: #64748b;
            margin: 0;
        }

        .alert-compact {
            padding: .8rem 1rem;
            margin-bottom: 1.25rem;
            border-radius: 14px;
            border-left: 4px solid #dc2626;
            background: #fef2f2;
            font-size: .92rem;
        }

        .alert-title {
            font-weight: 700;
            color: #991b1b;
            margin-bottom: .25rem;
        }

        .login-form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            font-size: .88rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: .5rem;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: #94a3b8;
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            height: 48px;
            padding: 0 1rem 0 2.6rem !important;
            border: 1.5px solid #dbe4f0;
            border-radius: 14px;
            font-size: .95rem;
            background: #fff;
            color: #0f172a;
            transition: .2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .12);
        }

        .form-control.is-invalid {
            border-color: #dc2626;
        }

        .error-text {
            display: block;
            margin-top: .35rem;
            font-size: .8rem;
            color: #dc2626;
        }

        .password-wrapper {
            padding-right: 3.15rem;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            width: 36px;
            height: 36px;
            border: 0;
            border-radius: 10px;
            background: transparent;
            color: #94a3b8;
            display: grid;
            place-items: center;
            cursor: pointer;
            transition: .2s ease;
        }

        .password-toggle:hover {
            background: #eff6ff;
            color: #2563eb;
        }

        .remember-row {
            display: inline-flex;
            align-items: center;
            gap: .65rem;
            font-size: .9rem;
            color: #475569;
            margin: .25rem 0 1.3rem;
            user-select: none;
        }

        .form-check-input {
            width: 16px;
            height: 16px;
            accent-color: #2563eb;
        }

        .btn-login {
            width: 100%;
            height: 48px;
            border: 0;
            border-radius: 14px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #fff;
            font-size: .98rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .65rem;
            box-shadow: 0 14px 30px rgba(37, 99, 235, .22);
            transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 34px rgba(37, 99, 235, .28);
            filter: brightness(1.02);
        }

        .login-footer {
            margin: 1rem 0 0;
            color: #64748b;
            font-size: .86rem;
            text-align: center;
            line-height: 1.5;
        }

        @media (max-width: 900px) {
            .login-panel {
                grid-template-columns: 1fr;
            }

            .login-hero {
                padding: 2rem;
            }

            .login-card {
                padding: 1.5rem;
            }
        }

        @media (max-width: 640px) {
            .login-shell {
                padding: 1rem;
            }

            .login-hero,
            .login-card {
                border-radius: 18px;
            }
        }
    </style>
@endsection

@push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function(){
        const form = document.querySelector('form[action="/login"]');
        const u = document.getElementById('username');
        const p = document.getElementById('password');
        const r = document.querySelector('input[name="remember"]');
        const toggleBtn = document.getElementById('togglePassword');

        if (form) { form.reset(); }

        const clearFields = () => {
            if (u) { u.value = ''; u.removeAttribute('readonly'); }
            if (p) { p.value = ''; p.removeAttribute('readonly'); }
            if (r) { r.checked = false; }
        };

        clearFields();
        setTimeout(clearFields, 50);
        setTimeout(clearFields, 500);

        if (u) { u.addEventListener('focus', () => u.removeAttribute('readonly')); }
        if (p) { p.addEventListener('focus', () => p.removeAttribute('readonly')); }

        // Password visibility toggle
        if (toggleBtn && p) {
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const isPassword = p.type === 'password';
                p.type = isPassword ? 'text' : 'password';
                toggleBtn.innerHTML = isPassword 
                    ? '<i class="fas fa-eye-slash"></i>' 
                    : '<i class="fas fa-eye"></i>';
            });
        }
    });
    </script>
@endpush
