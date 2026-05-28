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
        .dashboard-container {
            background: #f8fafc;
            min-height: 100vh;
            padding: 2rem;
        }

        .dashboard-header {
            margin-bottom: 2.5rem;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .dashboard-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 0.5rem 0;
        }

        .dashboard-subtitle {
            color: #64748b;
            font-size: 0.95rem;
            margin: 0;
        }

        .btn-header {
            padding: 0.65rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-header:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.2);
        }

        .stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #0ea5e9);
        }

        .stat-card.stat-card-teachers::before {
            background: linear-gradient(90deg, #10b981, #059669);
        }

        .stat-card.stat-card-degrees::before {
            background: linear-gradient(90deg, #8b5cf6, #7c3aed);
        }

        .stat-card.stat-card-signups::before {
            background: linear-gradient(90deg, #f59e0b, #d97706);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            border-color: #cbd5e1;
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stat-icon-blue {
            background: linear-gradient(135deg, #3b82f6, #0ea5e9);
        }

        .stat-icon-green {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .stat-icon-purple {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }

        .stat-icon-amber {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .stat-badge {
            background: #f1f5f9;
            color: #64748b;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .stat-card-body {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 500;
        }

        .stat-action {
            color: #3b82f6;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 0.5rem;
            transition: color 0.2s ease;
        }

        .stat-action:hover {
            color: #0ea5e9;
        }

        .dashboard-content {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 2rem;
        }

        @media (max-width: 1024px) {
            .dashboard-content {
                grid-template-columns: 1fr;
            }
        }

        .content-panel {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .panel-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .panel-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 0.25rem 0;
        }

        .panel-subtitle {
            color: #64748b;
            font-size: 0.85rem;
            margin: 0;
        }

        .table-container {
            overflow-x: auto;
        }

        .dashboard-table {
            width: 100%;
            border-collapse: collapse;
        }

        .dashboard-table thead tr {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        .dashboard-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #64748b;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .dashboard-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
            font-size: 0.9rem;
        }

        .dashboard-table tbody tr:hover {
            background: #f8fafc;
        }

        .student-name {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            color: #1e293b;
        }

        .student-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #0ea5e9);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .degree-badge {
            display: inline-block;
            background: #dbeafe;
            color: #1e40af;
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .degree-badge.badge-empty {
            background: #f1f5f9;
            color: #94a3b8;
        }

        .age-cell {
            color: #64748b;
            font-size: 0.9rem;
        }

        .action-cell {
            text-align: center;
        }

        .action-link {
            display: inline-block;
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .action-link:hover {
            background: #dbeafe;
            color: #0ea5e9;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem !important;
            color: #94a3b8;
        }

        .empty-state i {
            font-size: 2.5rem;
            opacity: 0.5;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            margin: 0.5rem 0 0 0;
        }

        .empty-state a {
            color: #3b82f6;
            font-weight: 600;
            text-decoration: none;
        }

        .actions-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            padding: 1.5rem;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 10px;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            border: 1.5px solid transparent;
            font-size: 1rem;
        }

        .action-btn i {
            font-size: 1.25rem;
            min-width: 20px;
        }

        .action-content {
            text-align: left;
            flex: 1;
        }

        .action-title {
            font-weight: 600;
            color: #1e293b;
            font-size: 0.9rem;
        }

        .action-desc {
            color: #94a3b8;
            font-size: 0.8rem;
            margin-top: 0.15rem;
        }

        .action-btn-primary {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
            border-color: #3b82f6;
        }

        .action-btn-primary:hover {
            background: linear-gradient(135deg, #bfdbfe 0%, #93c5fd 100%);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }

        .action-btn-secondary {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #166534;
            border-color: #10b981;
        }

        .action-btn-secondary:hover {
            background: linear-gradient(135deg, #bbf7d0 0%, #86efac 100%);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .action-btn-tertiary {
            background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
            color: #5b21b6;
            border-color: #8b5cf6;
        }

        .action-btn-tertiary:hover {
            background: linear-gradient(135deg, #ddd6fe 0%, #c4b5fd 100%);
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.2);
        }

        .action-btn-outline {
            background: #f8fafc;
            color: #64748b;
            border-color: #e2e8f0;
        }

        .action-btn-outline:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #1e293b;
        }
    </style>
@endsection
