@extends('layouts.app')

@section('title', 'Add New Student')

@section('content')
    <div class="form-container">
        <div class="form-wrapper">
            <div class="form-header">
                <div class="header-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h1 class="form-title">Add New Student</h1>
                <p class="form-subtitle">Enroll a new student in the system</p>
            </div>

            <div id="student-alert"></div>

            <div class="form-card">
            <div id="student-alert"></div>
            <form action="/student" method="POST" id="addStudentForm" data-redirect="{{ url('/students') }}" data-clear-login-fields="true" autocomplete="off">
                @csrf

                <div class="form-section">
                    <div class="section-title">Personal Information</div>

                    <!-- Name Row - 3 Columns -->
                    <div class="form-row form-row-3">
                        <div class="form-group">
                            <label for="fname" class="form-label">First Name</label>
                            <div class="input-wrapper">
                                <i class="fas fa-user input-icon"></i>
                                <input 
                                    type="text" 
                                    class="form-control @error('fname') is-invalid @enderror" 
                                    name="fname" 
                                    id="fname" 
                                    value="{{ old('fname') }}"
                                    placeholder="John"
                                    required>
                            </div>
                            @error('fname')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mname" class="form-label">Middle Name <span class="optional">(Optional)</span></label>
                            <div class="input-wrapper">
                                <i class="fas fa-user input-icon"></i>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    name="mname" 
                                    id="mname" 
                                    value="{{ old('mname') }}"
                                    placeholder="Michael">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lname" class="form-label">Last Name</label>
                            <div class="input-wrapper">
                                <i class="fas fa-user input-icon"></i>
                                <input 
                                    type="text" 
                                    class="form-control @error('lname') is-invalid @enderror" 
                                    name="lname" 
                                    id="lname" 
                                    value="{{ old('lname') }}"
                                    placeholder="Doe"
                                    required>
                            </div>
                            @error('lname')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Age & Degree Row -->
                    <div class="form-row form-row-2">
                        <div class="form-group">
                            <label for="age" class="form-label">Age</label>
                            <div class="input-wrapper">
                                <i class="fas fa-birthday-cake input-icon"></i>
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
                            </div>
                            @error('age')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="degree_id" class="form-label">Program / Degree</label>
                            <div class="input-wrapper">
                                <i class="fas fa-graduation-cap input-icon"></i>
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
                            </div>
                            @error('degree_id')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="section-title">Contact Information</div>

                    <!-- Email & Contact Row -->
                    <div class="form-row form-row-2">
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-wrapper">
                                <i class="fas fa-envelope input-icon"></i>
                                <input 
                                    type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    name="email" 
                                    id="email" 
                                    value="{{ old('email') }}"
                                    placeholder="john.doe@university.edu"
                                    required>
                            </div>
                            @error('email')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="contact" class="form-label">Contact Number</label>
                            <div class="input-wrapper">
                                <i class="fas fa-phone input-icon"></i>
                                <input 
                                    type="text" 
                                    class="form-control @error('contact') is-invalid @enderror" 
                                    name="contact" 
                                    id="contact" 
                                    value="{{ old('contact') }}"
                                    placeholder="+1 (555) 000-0000">
                            </div>
                            @error('contact')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="section-title">Account Credentials</div>

                    <!-- Username & Password Row -->
                    <div class="form-row form-row-2">
                        <div class="form-group">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-wrapper">
                                <i class="fas fa-at input-icon"></i>
                                <input 
                                    type="text" 
                                    class="form-control @error('username') is-invalid @enderror" 
                                    name="username" 
                                    id="username" 
                                    value="{{ old('username') }}"
                                    autocomplete="off"
                                    placeholder="john.doe123"
                                    required>
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
                                    value=""
                                    autocomplete="new-password"
                                    placeholder="Enter a secure password"
                                    required>
                                <button type="button" class="password-toggle" onclick="togglePasswordVisibility('password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-save">
                        <i class="fas fa-save"></i> Save Student
                    </button>
                    <a href="{{ url('/student') }}" class="btn btn-secondary btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <style>
        .form-container {
            background: linear-gradient(135deg, #f0f7ff 0%, #e6f2ff 100%);
            min-height: 100vh;
            padding: 2.5rem 1rem;
        }

        .form-wrapper {
            max-width: 900px;
            margin: 0 auto;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2.5rem;
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 1rem;
            background: linear-gradient(135deg, #3b82f6, #0ea5e9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
        }

        .form-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 0.5rem 0;
        }

        .form-subtitle {
            color: #64748b;
            font-size: 1rem;
            margin: 0;
        }

        .form-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid #e0e7ff;
            animation: slideUp 0.4s ease;
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

        .form-section {
            margin-bottom: 2rem;
        }

        .form-section:last-of-type {
            margin-bottom: 2.5rem;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e0e7ff;
        }

        .form-row {
            display: grid;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-row-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .form-row-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        @media (max-width: 768px) {
            .form-row-3,
            .form-row-2 {
                grid-template-columns: 1fr;
            }
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.6rem;
            display: flex;
            gap: 0.4rem;
        }

        .optional {
            color: #94a3b8;
            font-weight: 400;
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
            height: 44px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #ef4444;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
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

        .error-text {
            display: block;
            font-size: 0.8rem;
            color: #ef4444;
            margin-top: 0.4rem;
            font-weight: 500;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            flex: 1;
            height: 48px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #0ea5e9);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #64748b;
            border: 1.5px solid #cbd5e1;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            color: #334155;
        }
    </style>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            const btn = event.target.closest('.password-toggle');
            if (field.type === 'password') {
                field.type = 'text';
                btn.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                field.type = 'password';
                btn.innerHTML = '<i class="fas fa-eye"></i>';
            }
        }
    </script>
    @endpush
@endsection
