@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
    <div class="page-header mb-4">
        <div>
            <h1 class="page-header-title">My Profile</h1>
            <p class="page-header-subtitle">Your account information</p>
        </div>
    </div>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header">
            <h2 class="card-title">Account Details</h2>
        </div>
        <div class="card-body">
            <div style="margin-bottom: 20px;">
                <label style="font-weight: 600; color: #666;">Full Name</label>
                <p style="margin: 5px 0 0 0; font-size: 1.05rem;">{{ $account->name ?? 'N/A' }}</p>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: 600; color: #666;">Username</label>
                <p style="margin: 5px 0 0 0; font-size: 1.05rem;">{{ $account->username }}</p>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: 600; color: #666;">Email</label>
                <p style="margin: 5px 0 0 0; font-size: 1.05rem;">{{ $account->email }}</p>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: 600; color: #666;">Role</label>
                <p style="margin: 5px 0 0 0; font-size: 1.05rem;">
                    <span class="badge" style="background-color: {{ $role === 'student' ? '#007bff' : '#28a745' }}; color: white; padding: 5px 10px; border-radius: 4px;">
                        {{ ucfirst($role) }}
                    </span>
                </p>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: 600; color: #666;">Member Since</label>
                <p style="margin: 5px 0 0 0; font-size: 1.05rem;">{{ $account->created_at->format('F d, Y') }}</p>
            </div>
        </div>
        <div class="card-footer" style="text-align: center; padding: 15px;">
            <a href="{{ route('student.password.change') }}" class="btn btn-primary">
                <i class="fas fa-lock"></i> Change Password
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>
@endsection
