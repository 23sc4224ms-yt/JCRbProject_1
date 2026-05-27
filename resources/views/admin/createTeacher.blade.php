@extends('layouts.app')

@section('title', 'Add Teacher')

@section('content')
    <div class="page-header mb-4">
        <div>
            <h1 class="page-header-title">Add Teacher</h1>
            <p class="page-header-subtitle">Create a teacher account so they can access the portal.</p>
        </div>
    </div>

    <div class="card card-centered" style="max-width: 600px;">
        <div class="card-body">
            <form action="{{ route('admin.teachers.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required>
                    @error('username')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="actions actions-center">
                    <button type="submit" class="btn btn-primary btn-block">Create Teacher</button>
                </div>
            </form>
        </div>
    </div>
@endsection
