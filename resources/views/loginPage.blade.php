@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2 class="login-title">Login</h2>
                <p class="login-subtitle">Sign in to your account</p>
            </div>

            @if (isset($msg) || $errors->any())
                <div class="alert alert-danger alert-compact" role="alert">
                    <div class="alert-title">
                        <i class="fas fa-exclamation-circle"></i> Login Failed
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

            <form action="/login" method="POST" autocomplete="off">
                @csrf

                <!-- Username Field -->
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
                        <span class="text-danger error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Field with Toggle -->
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
                        <button type="button" class="password-toggle" id="togglePassword" tabindex="-1">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="text-danger error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" class="form-check-input" name="remember">
                        <span class="form-check-label">Remember me</span>
                    </label>
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn btn-primary btn-login">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>

                <!-- Footer -->
                <div class="login-footer">
                    <p>Need access? <strong>Ask your administrator</strong> to create your account.</p>
                </div>
            </form>
        </div>
    </div>

    <style>
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            padding: 1rem;
        }

        .login-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 2.5rem;
            width: 100%;
            max-width: 380px;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 1.8rem;
        }

        .login-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 0.5rem 0;
        }

        .login-subtitle {
            color: #64748b;
            font-size: 0.95rem;
            margin: 0;
        }

        .alert-compact {
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            border-left: 4px solid #dc2626;
            background-color: #fee2e2;
            font-size: 0.9rem;
        }

        .alert-title {
            font-weight: 600;
            color: #991b1b;
            margin-bottom: 0.25rem;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            color: #94a3b8;
            pointer-events: none;
            font-size: 1rem;
        }

        .form-control {
            padding-left: 38px !important;
            padding-right: 12px;
            height: 42px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #dc2626;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        .error-text {
            display: block;
            font-size: 0.8rem;
            margin-top: 0.35rem;
            color: #dc2626;
        }

        .password-wrapper {
            padding-right: 40px;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 1rem;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .password-toggle:hover {
            background-color: #f1f5f9;
            color: #64748b;
        }

        .password-toggle:active {
            background-color: #e2e8f0;
        }

        .form-check {
            display: flex;
            align-items: center;
            cursor: pointer;
            user-select: none;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            margin-right: 0.5rem;
            cursor: pointer;
            accent-color: #3b82f6;
        }

        .form-check-label {
            color: #64748b;
            font-size: 0.9rem;
            margin: 0;
        }

        .btn-login {
            width: 100%;
            height: 44px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1.5rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #64748b;
            font-size: 0.85rem;
            line-height: 1.5;
        }

        .login-footer strong {
            color: #1e293b;
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
