@extends('layouts.app')

@section('title', 'Student Details')

@section('content')
    <div class="page-header">
        <div class="header-content">
            <h1>Student Details</h1>
            <p class="header-subtitle">View complete student information</p>
        </div>
        <div class="header-actions">
            <a href="{{ url('/student/' . $student->id . '/edit') }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Student
            </a>
            <a href="{{ route('student.confirm-delete', $student->id) }}" class="btn btn-danger">
                <i class="fas fa-trash"></i> Delete Student
            </a>
            <a href="{{ url('/students') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    @if($student)
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="card-title">Personal Information</h2>
            </div>
            <div class="card-body">
                <div class="detail-grid">
                    <div>
                        <div class="detail-row">
                            <div class="detail-label">Student ID</div>
                            <div class="detail-value">{{ $student->id }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">First Name</div>
                            <div class="detail-value">{{ $student->fname }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Middle Name</div>
                            <div class="detail-value">{{ $student->mname ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="detail-row">
                            <div class="detail-label">Last Name</div>
                            <div class="detail-value">{{ $student->lname }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Age</div>
                            <div class="detail-value">{{ $student->age }} years</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Program</div>
                            <div class="detail-value">
                                @if($student->degree)
                                    <span class="badge badge-blue">{{ $student->degree->name }}</span>
                                @else
                                    <span class="badge badge-gray">Unassigned</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Contact Information</h2>
            </div>
            <div class="card-body">
                <div class="detail-grid">
                    <div>
                        <div class="detail-row">
                            <div class="detail-label">Email</div>
                            <div class="detail-value">{{ $student->email ?? 'Not provided' }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="detail-row">
                            <div class="detail-label">Contact Number</div>
                            <div class="detail-value">{{ $student->contact ?? 'Not provided' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">❌</div>
            <h2 class="empty-state-title">Student Not Found</h2>
            <p class="empty-state-text">The requested student could not be found in the system</p>
            <a href="{{ url('/students') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to Students
            </a>
        </div>
    @endif
@endsection
