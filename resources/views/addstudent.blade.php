@extends('layouts.app')

@section('title', 'Add New Student')

@section('content')
    <div class="page-header mb-4">
        <div>
            <h1 class="page-header-title">Add New Student</h1>
            <p class="page-header-subtitle">Enroll a new student in the system</p>
        </div>
    </div>

    <div class="card card-centered">
        <div class="card-header">
            <h2 class="card-title">Student Information</h2>
        </div>
        <div class="card-body">
            <div id="student-alert"></div>
            <form action="/student" method="POST" id="addStudentForm" data-redirect="{{ url('/students') }}" data-clear-login-fields="true" autocomplete="off">
                @csrf

                <!-- Name Row - 3 Columns -->
                <div class="form-row form-row-3">
                    <div class="form-group">
                        <label for="fname" class="form-label">First Name</label>
                        <input 
                            type="text" 
                            class="form-control @error('fname') is-invalid @enderror" 
                            name="fname" 
                            id="fname" 
                            value="{{ old('fname') }}"
                            placeholder="John"
                            required>
                        @error('fname')
                            <span class="text-danger" style="font-size: 0.75rem; margin-top: 2px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="mname" class="form-label">Middle Name <span class="text-muted">(Optional)</span></label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="mname" 
                            id="mname" 
                            value="{{ old('mname') }}"
                            placeholder="Michael">
                    </div>

                    <div class="form-group">
                        <label for="lname" class="form-label">Last Name</label>
                        <input 
                            type="text" 
                            class="form-control @error('lname') is-invalid @enderror" 
                            name="lname" 
                            id="lname" 
                            value="{{ old('lname') }}"
                            placeholder="Doe"
                            required>
                        @error('lname')
                            <span class="text-danger" style="font-size: 0.75rem; margin-top: 2px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Contact Row - 2 Columns -->
                <div class="form-row form-row-2">
                    <div class="form-group">
                        <label for="age" class="form-label">Age</label>
                        <input 
                            type="number" 
                            class="form-control @error('age') is-invalid @enderror" 
                            name="age" 
                            id="age" 
                            value="{{ old('age') }}"
                            placeholder="19"
                            min="16"
                            max="65"
                            required>
                        @error('age')
                            <span class="text-danger" style="font-size: 0.75rem; margin-top: 2px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="degree_id" class="form-label">Program / Degree</label>
                        <select 
                            name="degree_id" 
                            id="degree_id" 
                            class="form-control @error('degree_id') is-invalid @enderror"
                            required>
                            <option value="">Select a degree...</option>
                            @foreach($degrees as $degree)
                                <option value="{{ $degree->id }}" {{ old('degree_id') == $degree->id ? 'selected' : '' }}>
                                    {{ $degree->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('degree_id')
                            <span class="text-danger" style="font-size: 0.75rem; margin-top: 2px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Email & Contact Row - 2 Columns -->
                <div class="form-row form-row-2">
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            name="email" 
                            id="email" 
                            value="{{ old('email') }}"
                            placeholder="john.doe@university.edu"
                            required>
                        @error('email')
                            <span class="text-danger" style="font-size: 0.75rem; margin-top: 2px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="contact" class="form-label">Contact Number</label>
                        <input 
                            type="text" 
                            class="form-control @error('contact') is-invalid @enderror" 
                            name="contact" 
                            id="contact" 
                            value="{{ old('contact') }}"
                            placeholder="+1 (555) 000-0000">
                        @error('contact')
                            <span class="text-danger" style="font-size: 0.75rem; margin-top: 2px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Username & Password Row - 2 Columns -->
                <div class="form-row form-row-2">
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <input 
                            type="text" 
                            class="form-control @error('username') is-invalid @enderror" 
                            name="username" 
                            id="username" 
                            value="{{ old('username') }}"
                            autocomplete="off"
                            placeholder="john.doe123"
                            required>
                        @error('username')
                            <span class="text-danger" style="font-size: 0.75rem; margin-top: 2px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input 
                            type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            name="password" 
                            id="password" 
                            value=""
                            autocomplete="new-password"
                            placeholder="Enter a secure password"
                            required>
                        @error('password')
                            <span class="text-danger" style="font-size: 0.75rem; margin-top: 2px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="actions actions-center mt-4">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save"></i> Save Student
                    </button>
                    <a href="{{ url('/student') }}" class="btn btn-secondary btn-block">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
