@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
    <div class="page-header mb-4">
        <div>
            <h1 class="page-header-title">Change Password</h1>
            <p class="page-header-subtitle">Set your new student account password before continuing</p>
        </div>
    </div>

    <div class="card card-centered" style="max-width: 560px; margin: 2rem auto;">
        <div class="card-header">
            <h2 class="card-title"><i class="fas fa-lock"></i> Update Your Password</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('student.password.update') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="current_password" class="form-label"><i class="fas fa-key"></i> Current Password</label>
                    <input
                        type="password"
                        name="current_password"
                        id="current_password"
                        class="form-control @error('current_password') is-invalid @enderror"
                        placeholder="Enter your current password"
                        required>
                    @error('current_password')
                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label"><i class="fas fa-shield"></i> New Password</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Enter your new password"
                        required>
                    @error('password')
                        <span class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label"><i class="fas fa-check-circle"></i> Confirm New Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="form-control"
                        placeholder="Re-enter your new password"
                        required>
                </div>

                <button type="submit" class="btn btn-primary btn-block" style="margin-top:2rem;">
                    <i class="fas fa-save"></i> Save New Password
                </button>
            </form>
        </div>
    </div>
@endsection