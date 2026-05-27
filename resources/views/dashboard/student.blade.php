@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
    <div class="page-header mb-4">
        <div>
            <h1 class="page-header-title">Student Dashboard</h1>
            <p class="page-header-subtitle">Welcome back, {{ session('username') }}.</p>
        </div>
    </div>

    <div class="card card-centered">
        <div class="card-body">
            <p>Welcome, <strong>{{ session('name') }}</strong>.</p>
            <ul>
                <li><a href="{{ route('user.profile') }}"><i class="fas fa-user"></i> My Profile</a></li>
                <li><a href="{{ route('student.password.change') }}"><i class="fas fa-lock"></i> Change Password</a></li>
            </ul>
        </div>
    </div>
@endsection
