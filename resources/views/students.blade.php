
@extends('layouts.app')

@section('title', 'Students')

@section('content')
    <div class="page-header mb-4">
        <div>
            <h1 class="page-header-title">Students</h1>
            <p class="page-header-subtitle">Complete list of all enrolled students</p>
        </div>
        <a href="{{ url('/student/create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Student
        </a>
    </div>

    @forelse ($students as $student)
        @if ($loop->first)
            <div class="card">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Age</th>
                                <th>Program</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
        @endif
                        <tr>
                            <td><strong>{{ $loop->iteration }}</strong></td>
                            <td>{{ $student->fname }} {{ $student->mname }} {{ $student->lname }}</td>
                            <td>{{ $student->age }}</td>
                            <td>
                                @if($student->degree)
                                    <span class="badge badge-blue">{{ $student->degree->name }}</span>
                                @else
                                    <span class="badge badge-gray">Unassigned</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions actions-compact">
                                    <a href="{{ url('/student/' . $student->id) }}" class="btn btn-sm btn-secondary" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ url('/student/' . $student->id . '/edit') }}" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('student.confirm-delete', $student->id) }}" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Delete {{ $student->fname }}?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
        @if ($loop->last)
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @empty
        <div class="empty-state">
            <div class="empty-state-icon">📋</div>
            <h2 class="empty-state-title">No Students Found</h2>
            <p class="empty-state-text">The student roster is currently empty</p>
            <a href="{{ url('/student/create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add First Student
            </a>
        </div>
    @endforelse
@endsection