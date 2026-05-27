@extends('layouts.app')

@section('title', 'Delete Student')

@section('content')
    <div class="page-header">
        <div class="header-content">
            <h1>Delete Student</h1>
            <p class="header-subtitle">Confirm deletion of student record</p>
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
                <strong>Warning!</strong> This action is irreversible. All associated data will be permanently deleted.
            </div>

            <div class="student-info-preview">
                <h3>Student to be deleted:</h3>
                <div class="detail-grid">
                    <div>
                        <div class="detail-row">
                            <div class="detail-label">Student ID</div>
                            <div class="detail-value">{{ $student->id }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Full Name</div>
                            <div class="detail-value">{{ $student->fname }} {{ $student->mname }} {{ $student->lname }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Email</div>
                            <div class="detail-value">{{ $student->email ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="detail-row">
                            <div class="detail-label">Age</div>
                            <div class="detail-value">{{ $student->age ?? 'N/A' }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Degree</div>
                            <div class="detail-value">{{ $student->degree ? $student->degree->name : 'N/A' }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Contact</div>
                            <div class="detail-value">{{ $student->contact ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="deletion-info" style="margin-top: 2rem; padding: 1rem; background-color: #fff3cd; border-left: 4px solid #ffc107; border-radius: 0.25rem;">
                <h4>The following will be deleted:</h4>
                <ul style="margin-bottom: 0;">
                    <li>Student personal information (name, contact, age)</li>
                    <li>Student degree and course assignments</li>
                    <li>Associated activity logs</li>
                    <li>Related posts and submissions</li>
                </ul>
            </div>

            <div class="action-buttons" style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="{{ url('/student/' . $student->id) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <form action="{{ url('/student/' . $student->id) }}" method="POST" style="display: inline;" id="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('⚠️ Are you absolutely sure? This will permanently delete:\n\n• Student: {{ $student->fname }} {{ $student->lname }}\n• All associated data\n\nThis action CANNOT be undone!');">
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

        .student-info-preview {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 0.25rem;
            margin: 1rem 0;
        }

        .student-info-preview h3 {
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
    </style>
@endsection
