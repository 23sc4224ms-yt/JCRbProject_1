@extends('layouts.app')

@section('title', 'Activity Logs')

@section('content')
    <div class="page-header mb-4">
        <div>
            <h1 class="page-header-title">Activity Logs</h1>
            <p class="page-header-subtitle">Track all student record changes and activities</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Filters -->
            <form method="GET" action="/activity-logs" class="mb-4">
                <div class="form-row form-row-3">
                    <div class="form-group">
                        <label for="student_id" class="form-label">Filter by Student</label>
                        <select name="student_id" id="student_id" class="form-control">
                            <option value="">All Students</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->fname }} {{ $student->lname }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="action" class="form-label">Filter by Action</label>
                        <select name="action" id="action" class="form-control">
                            <option value="">All Actions</option>
                            <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Created</option>
                            <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Updated</option>
                            <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="date_from" class="form-label">From Date</label>
                        <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                </div>

                <div class="form-row form-row-2">
                    <div class="form-group">
                        <label for="date_to" class="form-label">To Date</label>
                        <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>

                    <div class="form-group" style="display: flex; align-items: flex-end; gap: 10px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="/activity-logs" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>

            <!-- Activity Logs Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Action</th>
                            <th>Summary</th>
                            <th>Date & Time</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>
                                    <strong>
                                        @if($log->student)
                                            {{ $log->student->fname }} {{ $log->student->lname }}
                                        @else
                                            <span class="text-muted">Deleted Student</span>
                                        @endif
                                    </strong>
                                </td>
                                <td>
                                    @if($log->action === 'created')
                                        <span class="badge badge-success">Created</span>
                                    @elseif($log->action === 'updated')
                                        <span class="badge badge-info">Updated</span>
                                    @else
                                        <span class="badge badge-danger">Deleted</span>
                                    @endif
                                </td>
                                <td>{{ $log->changes_summary }}</td>
                                <td>{{ $log->created_at->format('M d, Y h:i A') }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $log->id }}">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                </td>
                            </tr>

                            <!-- Details Modal -->
                            <div class="modal fade" id="detailsModal{{ $log->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Activity Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <h6>Action Type:</h6>
                                                    <p>
                                                        @if($log->action === 'created')
                                                            <span class="badge badge-success">Created</span>
                                                        @elseif($log->action === 'updated')
                                                            <span class="badge badge-info">Updated</span>
                                                        @else
                                                            <span class="badge badge-danger">Deleted</span>
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6>Date & Time:</h6>
                                                    <p>{{ $log->created_at->format('M d, Y h:i A') }}</p>
                                                </div>
                                            </div>

                                            @if($log->action === 'created' && $log->new_values)
                                                <h6>Created With:</h6>
                                                <table class="table table-sm table-bordered">
                                                    <tr>
                                                        <td colspan="2" class="table-info"><strong>New Data</strong></td>
                                                    </tr>
                                                    @foreach($log->new_values as $key => $value)
                                                        <tr>
                                                            <td style="width: 30%"><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}</strong></td>
                                                            <td>{{ $value ?? 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            @elseif($log->action === 'updated' && $log->old_values && $log->new_values)
                                                <h6>Changes:</h6>
                                                <table class="table table-sm table-bordered">
                                                    @foreach($log->new_values as $key => $newValue)
                                                        @if(isset($log->old_values[$key]) && $log->old_values[$key] != $newValue)
                                                            <tr>
                                                                <td style="width: 30%"><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}</strong></td>
                                                                <td>
                                                                    <div class="text-danger"><strike>{{ $log->old_values[$key] ?? 'N/A' }}</strike></div>
                                                                    <div class="text-success">{{ $newValue ?? 'N/A' }}</div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </table>
                                            @elseif($log->action === 'deleted' && $log->old_values)
                                                <h6>Deleted Data:</h6>
                                                <table class="table table-sm table-bordered">
                                                    <tr>
                                                        <td colspan="2" class="table-danger"><strong>Deleted Information</strong></td>
                                                    </tr>
                                                    @foreach($log->old_values as $key => $value)
                                                        <tr>
                                                            <td style="width: 30%"><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}</strong></td>
                                                            <td>{{ $value ?? 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    No activity logs found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $logs->links() }}
            </div>
        </div>
    </div>

    <style>
        .badge {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
        
        .badge-success { background-color: #28a745; color: white; }
        .badge-info { background-color: #17a2b8; color: white; }
        .badge-danger { background-color: #dc3545; color: white; }
        
        .table-info { background-color: #e7f3ff; }
        .table-danger { background-color: #ffe7e7; }
    </style>
@endsection
