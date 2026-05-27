@extends('layouts.app')

@section('title', 'Teacher Dashboard')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-header-title">Teacher Dashboard</h1>
            <p class="page-header-subtitle">Welcome, {{ session('name') ?? session('username') }}.</p>
        </div>
        <a href="{{ route('teacher.courses') }}" class="btn btn-primary">
            <i class="fas fa-book-open"></i> Course
        </a>
    </div>

    <div class="stats-grid-large teacher-stats">
        <div class="stat-card-large stat-blue">
            <div class="stat-icon-box"><i class="fas fa-users"></i></div>
            <div class="stat-number">{{ $totalEnrolled ?? 0 }}</div>
            <div class="stat-label">Assigned Students</div>
        </div>
        <div class="stat-card-large stat-green">
            <div class="stat-icon-box"><i class="fas fa-book"></i></div>
            <div class="stat-number">{{ count($courses ?? []) }}</div>
            <div class="stat-label">Courses</div>
        </div>
        <div class="stat-card-large stat-purple">
            <div class="stat-icon-box"><i class="fas fa-user-tie"></i></div>
            <div class="stat-number">1</div>
            <div class="stat-label">{{ $teacher?->name ?? 'Teacher' }}</div>
        </div>
    </div>

    <div class="course-board">
        @forelse($courses ?? [] as $course)
            <a href="{{ route('teacher.courses.show', $course) }}" class="course-tile">
                <span class="course-title">{{ $course->name }}</span>
                <span class="course-teacher">{{ $course->teacher?->name ?? $teacher?->name ?? 'No teacher assigned' }}</span>
                <span class="course-count">{{ $course->students->count() }} students</span>
            </a>
        @empty
            <div class="card">
                <div class="card-body">No courses yet.</div>
            </div>
        @endforelse
    </div>

    <div class="card compact-card">
        <div class="card-body">
            <div class="section-heading">
                <h2>All Students</h2>
                <a href="{{ route('teacher.add-student') }}" class="btn btn-success"><i class="fas fa-plus"></i> Add Student</a>
            </div>
            <div class="compact-student-grid">
                @forelse($enrolledStudents ?? [] as $student)
                    <div class="student-chip">
                        <strong>{{ $student->fname }} {{ $student->lname }}</strong>
                        <span>{{ $student->degree?->name ?? 'No degree' }}</span>
                    </div>
                @empty
                    <p style="color:#64748b;font-weight:600;">No students assigned yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
