@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="dashboard-container">
        <!-- Header Section -->
        <div class="dashboard-header">
            <div class="header-content">
                <div>
                    <h1 class="dashboard-title">Admin Dashboard</h1>
                    <p class="dashboard-subtitle">Welcome back, <strong>{{ session('username') }}</strong></p>
                </div>
                <a href="{{ url('/degree') }}" class="btn btn-primary btn-header">
                    <i class="fas fa-graduation-cap"></i> Manage Degrees
                </a>
            </div>
        </div>

        <!-- Stats Grid Section -->
        <div class="stats-section">
            <div class="stat-card stat-card-students" onclick="window.location='{{ url('/students') }}'">
                <div class="stat-card-header">
                    <div class="stat-icon stat-icon-blue">
                        <i class="fas fa-users"></i>
                    </div>
                    <span class="stat-badge">Total</span>
                </div>
                <div class="stat-card-body">
                    <div class="stat-number">{{ $totalStudents ?? 0 }}</div>
                    <div class="stat-label">Students</div>
                    <a href="{{ url('/students') }}" class="stat-action">View all →</a>
                </div>
            </div>

            <div class="stat-card stat-card-teachers" onclick="window.location='{{ url('/teachers') }}'">
                <div class="stat-card-header">
                    <div class="stat-icon stat-icon-green">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <span class="stat-badge">Total</span>
                </div>
                <div class="stat-card-body">
                    <div class="stat-number">{{ $totalTeachers ?? 0 }}</div>
                    <div class="stat-label">Teachers</div>
                    <a href="{{ url('/teachers') }}" class="stat-action">View all →</a>
                </div>
            </div>

            <div class="stat-card stat-card-degrees" onclick="window.location='{{ url('/degree') }}'">
                <div class="stat-card-header">
                    <div class="stat-icon stat-icon-purple">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <span class="stat-badge">Total</span>
                </div>
                <div class="stat-card-body">
                    <div class="stat-number">{{ $totalDegrees ?? 0 }}</div>
                    <div class="stat-label">Degrees</div>
                    <a href="{{ url('/degree') }}" class="stat-action">View all →</a>
                </div>
            </div>

            <div class="stat-card stat-card-signups">
                <div class="stat-card-header">
                    <div class="stat-icon stat-icon-amber">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <span class="stat-badge">This Month</span>
                </div>
                <div class="stat-card-body">
                    <div class="stat-number">0</div>
                    <div class="stat-label">New Signups</div>
                    <a href="#" class="stat-action">View details →</a>
                </div>
            </div>
        </div>

        <!-- Main Content Section -->
        <div class="dashboard-content">
            <!-- Recent Students Panel -->
            <div class="content-panel recent-students">
                <div class="panel-header">
                    <div>
                        <h2 class="panel-title">Recent Students</h2>
                        <p class="panel-subtitle">Latest 5 students added to the system</p>
                    </div>
                </div>

                <div class="table-container">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Degree</th>
                                <th>Age</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\Student::latest()->take(5)->get() as $s)
                            <tr>
                                <td class="student-name">
                                    <div class="student-avatar">{{ substr($s->fname, 0, 1) }}</div>
                                    {{ $s->fname }} {{ $s->lname }}
                                </td>
                                <td>
                                    @if($s->degree)
                                        <span class="degree-badge">{{ $s->degree->name }}</span>
                                    @else
                                        <span class="degree-badge badge-empty">N/A</span>
                                    @endif
                                </td>
                                <td class="age-cell">{{ $s->age }} yrs</td>
                                <td class="action-cell">
                                    <a href="{{ url('/students/' . $s->id) }}" class="action-link">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>No students yet. <a href="/student/create">Create one</a></p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Actions Panel -->
            <div class="content-panel quick-actions">
                <div class="panel-header">
                    <h2 class="panel-title">Quick Actions</h2>
                </div>

                <div class="actions-list">
                    <a href="/student/create" class="action-btn action-btn-primary">
                        <i class="fas fa-user-plus"></i>
                        <div class="action-content">
                            <div class="action-title">Add Student</div>
                            <div class="action-desc">Register new student</div>
                        </div>
                    </a>

                    <a href="{{ route('admin.teachers.create') }}" class="action-btn action-btn-secondary">
                        <i class="fas fa-chalkboard-user"></i>
                        <div class="action-content">
                            <div class="action-title">Add Teacher</div>
                            <div class="action-desc">Hire new teacher</div>
                        </div>
                    </a>

                    <a href="{{ url('/degree') }}" class="action-btn action-btn-tertiary">
                        <i class="fas fa-graduation-cap"></i>
                        <div class="action-content">
                            <div class="action-title">Manage Degrees</div>
                            <div class="action-desc">View & edit degrees</div>
                        </div>
                    </a>

                    <a href="{{ url('/students') }}" class="action-btn action-btn-outline">
                        <i class="fas fa-list"></i>
                        <div class="action-content">
                            <div class="action-title">View All Students</div>
                            <div class="action-desc">Complete student list</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root{--primary:#2563eb;--muted:#64748b;--bg:#f8fafc;--card:#ffffff;--radius:14px}
        .dashboard-container{background:var(--bg);min-height:100vh;padding:2rem}

        .dashboard-header{margin-bottom:2.25rem}
        .header-content{display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap}
        .dashboard-title{font-size:1.75rem;font-weight:800;color:#0f172a;margin:0}
        .dashboard-subtitle{color:var(--muted);margin:0;font-weight:600}

        .btn-header{padding:.6rem 1.2rem;border-radius:12px;font-weight:700;background:linear-gradient(135deg,rgba(37,99,235,.08),rgba(37,99,235,.06));border:1px solid rgba(37,99,235,.12);color:var(--primary)}

        .stats-section{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:1.25rem;margin-bottom:2rem}

        .stat-card{background:var(--card);border-radius:var(--radius);padding:1.25rem 1.25rem 1.5rem;box-shadow:0 10px 30px rgba(15,23,42,.04);border:1px solid rgba(15,23,42,.03);position:relative;overflow:hidden;transition:transform .18s ease,box-shadow .18s ease}
        .stat-card:hover{transform:translateY(-6px);box-shadow:0 22px 46px rgba(15,23,42,.07)}

        .stat-card-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:.75rem}
        .stat-icon{width:56px;height:56px;border-radius:12px;display:grid;place-items:center;color:#fff;font-size:1.35rem}
        .stat-icon-blue{background:linear-gradient(135deg,#3b82f6,#0ea5e9)}
        .stat-icon-green{background:linear-gradient(135deg,#10b981,#059669)}
        .stat-icon-purple{background:linear-gradient(135deg,#8b5cf6,#7c3aed)}
        .stat-icon-amber{background:linear-gradient(135deg,#f59e0b,#d97706)}

        .stat-badge{background:#f1f5f9;color:var(--muted);padding:.25rem .6rem;border-radius:999px;font-weight:700;font-size:.78rem}

        .stat-card-body{display:flex;flex-direction:column;gap:.25rem}
        .stat-number{font-size:2.6rem;font-weight:900;color:#0f172a;letter-spacing:-.02em}
        .stat-label{color:var(--muted);font-weight:700}
        .stat-action{margin-top:.5rem;color:var(--primary);font-weight:700;text-decoration:none}

        .dashboard-content{display:grid;grid-template-columns:1fr 360px;gap:1.5rem}
        @media(max-width:1024px){.dashboard-content{grid-template-columns:1fr}}

        .content-panel{background:var(--card);border-radius:12px;padding:0;overflow:hidden;border:1px solid rgba(15,23,42,.03);box-shadow:0 8px 30px rgba(15,23,42,.04)}
        .panel-header{padding:1.25rem;border-bottom:1px solid rgba(15,23,42,.04)}
        .panel-title{font-size:1.1rem;font-weight:800;margin:0;color:#0f172a}
        .panel-subtitle{color:var(--muted);margin:0;font-size:.9rem}

        .table-container{overflow:auto;padding:1rem}
        .dashboard-table{width:100%;border-collapse:collapse}
        .dashboard-table thead tr{background:transparent}
        .dashboard-table th{padding:.8rem 1rem;text-align:left;font-weight:700;color:var(--muted);font-size:.78rem;text-transform:uppercase}
        .dashboard-table td{padding:.9rem 1rem;border-bottom:1px solid rgba(15,23,42,.03);color:#0f172a}
        .dashboard-table tbody tr:hover{background:rgba(37,99,235,.03)}

        .student-name{display:flex;align-items:center;gap:.75rem;font-weight:700}
        .student-avatar{width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#3b82f6,#0ea5e9);color:#fff;display:grid;place-items:center;font-weight:800}

        .degree-badge{display:inline-block;background:#eef2ff;color:#1e293b;padding:.25rem .6rem;border-radius:8px;font-weight:700}
        .degree-badge.badge-empty{background:#f1f5f9;color:var(--muted)}

        .age-cell{color:var(--muted)}
        .action-cell{text-align:center}
        .action-link{color:var(--primary);font-weight:800;text-decoration:none;padding:.35rem .6rem;border-radius:8px}
        .action-link:hover{background:linear-gradient(135deg,#dbeafe,#eff6ff)}

        .empty-state{padding:2.5rem;text-align:center;color:var(--muted)}

        .actions-list{display:flex;flex-direction:column;gap:.65rem;padding:1rem}
        .action-btn{display:flex;align-items:center;gap:.85rem;padding:.9rem;border-radius:12px;text-decoration:none;border:1px solid transparent}
        .action-btn i{font-size:1.15rem}
        .action-content{flex:1}
        .action-title{font-weight:800;color:#0f172a}
        .action-desc{color:var(--muted);font-size:.85rem}

        .action-btn-primary{background:linear-gradient(135deg,#eef2ff,#e0f2ff);border-color:rgba(59,130,246,.12);color:#0f172a}
        .action-btn-secondary{background:linear-gradient(135deg,#f0fdf4,#e6fff0);border-color:rgba(16,185,129,.12)}
        .action-btn-tertiary{background:linear-gradient(135deg,#faf5ff,#f3e8ff);border-color:rgba(139,92,246,.12)}
        .action-btn-outline{background:transparent;border-color:rgba(15,23,42,.04);color:var(--muted)}
    </style>
@endsection
