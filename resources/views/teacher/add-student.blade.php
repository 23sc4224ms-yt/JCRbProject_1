@extends('layouts.app')

@section('title', 'Add Student')

@section('content')
    <div class="page-header mb-4">
        <div>
            <h1 class="page-header-title">Add Student</h1>
            <p class="page-header-subtitle">Enroll a new student under your supervision</p>
        </div>
    </div>

    <div class="card card-centered" style="margin-bottom: 2rem;">
        <div class="card-body">
            <form action="{{ route('teacher.store-student') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="student_id" class="form-label">Select Student</label>
                    <select name="student_id" id="student_id" class="form-control @error('student_id') is-invalid @enderror" required>
                        <option value="">-- Choose a student --</option>
                        @forelse($availableStudents as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->fname }} {{ $student->mname }} {{ $student->lname }} 
                                ({{ $student->degree ? $student->degree->name : 'N/A' }})
                            </option>
                        @empty
                            <option value="" disabled>No available students</option>
                        @endforelse
                    </select>
                    @error('student_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: flex; gap: 1rem; justify-content: center;">
                    <button type="submit" class="btn btn-success" style="padding: 0.75rem 2rem;">
                        <i class="fas fa-check"></i> Add Student
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="padding: 0.75rem 2rem;">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
