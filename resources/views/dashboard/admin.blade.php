@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div>
        <div class="page-header mb-3">
            <div>
                <h1 class="page-header-title">Admin Dashboard</h1>
                <p class="page-header-subtitle">Welcome, {{ session('username') }}.</p>
            </div>
            <a href="{{ route('teacher.courses') }}" class="btn btn-primary">
                <i class="fas fa-book-open"></i> Course
            </a>
        </div>

        <div class="stats-grid-large">
            <div class="stat-card-large stat-blue">
                <div>
                    <div class="stat-icon-box"><i class="fas fa-users"></i></div>
                </div>
                <div class="stat-number">{{ $totalStudents ?? 0 }}</div>
                <div class="stat-label">Students</div>
                <div><a href="{{ url('/students') }}" class="stat-link">View list</a></div>
            </div>

            <div class="stat-card-large stat-green">
                <div>
                    <div class="stat-icon-box"><i class="fas fa-chalkboard-teacher"></i></div>
                </div>
                <div class="stat-number">{{ $totalTeachers ?? 0 }}</div>
                <div class="stat-label">Teachers</div>
                <div><a href="{{ url('/teachers') }}" class="stat-link">View list</a></div>
            </div>

            <div class="stat-card-large stat-purple">
                <div>
                    <div class="stat-icon-box"><i class="fas fa-book-open"></i></div>
                </div>
                <div class="stat-number">{{ count($courses ?? []) }}</div>
                <div class="stat-label">Courses</div>
                <div><a href="{{ route('teacher.courses') }}" class="stat-link">View list</a></div>
            </div>

            <div class="stat-card-large stat-amber">
                <div>
                    <div class="stat-icon-box"><i class="fas fa-user-plus"></i></div>
                </div>
                <div class="stat-number">0</div>
                <div class="stat-label">New Signups</div>
                <div><a href="#" class="stat-link">Details</a></div>
            </div>
        </div>

        <div class="bottom-grid">
            <div>
                <div class="card">
                    <div class="card-body">
                        <h3 style="margin-top:0;">Recent Students</h3>
                        <p class="text-muted">Latest 5 students added</p>
                        <div class="table-wrapper" style="margin-top:0.75rem;">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Degree</th>
                                        <th>Age</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\Student::latest()->take(5)->get() as $s)
                                    <tr>
                                        <td>{{ $s->fname }} {{ $s->lname }}</td>
                                        <td>
                                            @if($s->degree)
                                                <span class="badge-pill badge-bsit">{{ $s->degree->name }}</span>
                                            @else
                                                <span class="badge-pill badge-default">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $s->age }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="card right-panel">
                    <h4>Quick Actions</h4>
                    <div style="display:flex; flex-direction:column; gap:0.6rem; margin-top:0.8rem;">
                        <a href="/student/create" class="btn btn-primary">Add Student</a>
                        <a href="{{ route('teacher.courses') }}" class="btn btn-primary">Course</a>
                        <a href="{{ route('admin.teachers.create') }}" class="btn btn-secondary">Add Teacher</a>
                        <a href="{{ url('/degree') }}" class="btn btn-outline">Manage Degrees</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
