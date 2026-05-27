@extends('layouts.app')

@section('title', 'Delete Teacher')

@section('content')
    <div class="page-header">
        <div class="header-content">
            <h1>Delete Teacher</h1>
            <p class="header-subtitle">Confirm deletion of teacher account</p>
        </div>
    </div>

    <div class="card card-danger">
        <div class="card-header bg-danger">
            <h2 class="card-title text-white">
                <i class="fas fa-exclamation-triangle"></i> Permanent Deletion
            </h2>
        </div>
        <div class="card-body">
            <div class="alert alert-danger" role="alert">
                <strong>Warning!</strong> This action is irreversible. All teacher account data will be permanently deleted.
            </div>

            <div class="teacher-info-preview">
                <h3>Teacher account to be deleted:</h3>
                <div class="detail-grid">
                    <div>
                        <div class="detail-row">
                            <div class="detail-label">Teacher ID</div>
                            <div class="detail-value">{{ $teacher->id }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Full Name</div>
                            <div class="detail-value">{{ $teacher->name }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Username</div>
                            <div class="detail-value">{{ $teacher->username }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="detail-row">
                            <div class="detail-label">Email</div>
                            <div class="detail-value">{{ $teacher->email }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Role</div>
                            <div class="detail-value">
                                <span class="badge badge-primary">Teacher</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="deletion-info" style="margin-top: 2rem; padding: 1rem; background-color: #fff3cd; border-left: 4px solid #ffc107; border-radius: 0.25rem;">
                <h4>The following will be deleted:</h4>
                <ul style="margin-bottom: 0;">
                    <li>Teacher account information (name, username, email)</li>
                    <li>Teacher authentication credentials</li>
                    <li>Associated teaching records and assignments</li>
                    <li>Activity logs related to this teacher</li>
                </ul>
            </div>

            <div class="action-buttons" style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="{{ url('/teachers') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <form action="{{ route('teacher.destroy', $teacher->id) }}" method="POST" style="display: inline;" id="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('⚠️ Are you absolutely sure? This will permanently delete:\n\n• Teacher: {{ $teacher->name }}\n• Username: {{ $teacher->username }}\n• All associated records\n\nThis action CANNOT be undone!');">
                        <i class="fas fa-trash"></i> Yes, Delete Permanently
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .card-danger {
            border-left: 4px solid #dc3545;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }

        .text-white {
            color: white !important;
        }

        .teacher-info-preview {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 0.25rem;
            margin: 1rem 0;
        }

        .teacher-info-preview h3 {
            margin-top: 0;
            margin-bottom: 1rem;
            color: #333;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        @media (max-width: 768px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }
        }

        .detail-row {
            margin-bottom: 1rem;
        }

        .detail-label {
            font-weight: 600;
            color: #666;
            font-size: 0.875rem;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }

        .detail-value {
            color: #333;
            font-size: 1rem;
        }

        .deletion-info {
            border-radius: 0.25rem;
        }

        .deletion-info h4 {
            margin-top: 0;
            margin-bottom: 0.75rem;
            color: #856404;
        }

        .deletion-info ul {
            padding-left: 1.25rem;
        }

        .deletion-info li {
            color: #856404;
            margin-bottom: 0.5rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        @media (max-width: 576px) {
            .action-buttons {
                flex-direction: column;
            }

            .action-buttons .btn {
                width: 100%;
            }
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .badge-primary {
            background-color: #0044cc;
            color: white;
        }
    </style>
@endsection
