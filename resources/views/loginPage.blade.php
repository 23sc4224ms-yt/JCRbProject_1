@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="page-header mb-4">
        <div>
            <h1 class="page-header-title">Login</h1>
            <p class="page-header-subtitle">Sign in to your account</p>
        </div>
    </div>

    <div class="card card-centered" style="max-width: 400px;">
        <div class="card-header">
            <h2 class="card-title">User Login</h2>
        </div>
        <div class="card-body">
            @if (isset($msg) || $errors->any())
                <div class="alert alert-danger alert-auto-dismiss" role="alert">
                    <div class="alert-title">Login Failed</div>
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
                    @error('username')
                        <span class="text-danger" style="font-size: 0.75rem; margin-top: 2px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        name="password" 
                        id="password" 
                        placeholder="Enter your password"
                        autocomplete="new-password"
                        readonly
                        required>
                    @error('password')
                        <span class="text-danger" style="font-size: 0.75rem; margin-top: 2px;">{{ $message }}</span>
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
                <div class="actions actions-center">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>
                </div>

                <!-- Sign Up Link -->
                <div style="text-align: center; margin-top: 15px;">
                    <p>Need access? <strong>Ask your administrator</strong> to create your account.</p>
                </div>
            </form>
        </div>
    </div>
@endsection

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function(){
        const form = document.querySelector('form[action="/login"]');
        const u = document.getElementById('username');
        const p = document.getElementById('password');
        const r = document.querySelector('input[name="remember"]');

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
    });
    </script>
    @endpush
