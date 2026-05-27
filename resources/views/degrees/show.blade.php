@extends('layouts.app')

@section('content')

<div class="page-header">
    <div class="header-content">
        <h1>{{ $degree->name }}</h1>
        <p class="header-subtitle">Academic degree details and enrolled students</p>
    </div>
    <div class="header-actions">
        <a href="/degree/{{ $degree->id }}/edit" class="btn btn-primary">Edit</a>
        <form action="/degree/{{ $degree->id }}" method="POST" onsubmit="return confirm('Are you sure?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <a href="/degree" class="btn btn-secondary">Back</a>
    </div>
</div>

<!-- Degree Detail Card -->
<div class="card">
    <div class="detail-grid detail-grid-2">
        <div class="detail-item">
            <span class="detail-label">Degree ID</span>
            <span class="detail-value">{{ $degree->id }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Degree Name</span>
            <span class="detail-value">{{ $degree->name }}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Total Students</span>
            <span class="detail-value"><span class="badge badge-primary">{{ $students->total() }}</span></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Total Courses</span>
            <span class="detail-value"><span class="badge badge-success">{{ $courses->count() }}</span></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Status</span>
            <span class="detail-value"><span class="badge badge-success">Active</span></span>
        </div>
    </div>
</div>

<!-- Courses Section -->
<h3 style="margin-top: 2rem; margin-bottom: 1rem; color: var(--color-text); font-weight: 500;">Courses / Subjects</h3>

@if($courses->count() > 0)
    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Teacher</th>
                        <th>Students</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                    <tr>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->teacher?->name ?? 'No teacher assigned' }}</td>
                        <td>{{ $course->students->count() }}</td>
                        <td>
                            <a href="{{ route('teacher.courses.show', $course) }}" class="btn btn-secondary">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="empty-state">
        <h3>No Courses Yet</h3>
        <p>No courses are currently assigned to this degree.</p>
    </div>
@endif

<!-- Enrolled Students Section -->
<h3 style="margin-top: 2rem; margin-bottom: 1rem; color: var(--color-text); font-weight: 500;">Enrolled Students</h3>

@if($students->count() > 0)
    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->fname }} {{ $student->mname ?? '' }} {{ $student->lname }}</td>
                        <td>{{ $student->email ?? 'N/A' }}</td>
                        <td>{{ $student->contact ?? 'N/A' }}</td>
                        <td>
                            <div class="actions">
                                <a href="/student/{{ $student->id }}" class="btn btn-secondary">View</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination Links -->
    @if($students->hasPages())
    <div class="pagination-wrapper">
        {{ $students->links() }}
    </div>
    @endif
@else
    <div class="empty-state">
        <div class="empty-icon">👥</div>
        <h3>No Students Enrolled</h3>
        <p>No students are currently enrolled in this degree program.</p>
    </div>
@endif

@endsection
