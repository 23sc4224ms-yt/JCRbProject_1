@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="page-header mb-4">
        <div>
            <h1 class="page-header-title">Dashboard</h1>
            <p class="page-header-subtitle">Student enrollment overview and management</p>
        </div>
        <a href="{{ url('/student/create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Student
        </a>
    </div>

    @if($students->count() > 0)
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Enrolled Students</h2>
            </div>
            <div class="card-body">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Age</th>
                                <th>Program</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td><strong>{{ $student->id }}</strong></td>
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">👥</div>
            <h2 class="empty-state-title">No Students Yet</h2>
            <p class="empty-state-text">Start by adding your first student to the system</p>
            <a href="{{ url('/student/create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add First Student
            </a>
        </div>
    @endif
@endsection