@extends('layouts.app')

@section('content')

<div class="page-header">
    <div class="header-content">
        <h1>Degree Management</h1>
        <p class="header-subtitle">Manage all academic degrees and their enrollment</p>
    </div>
    <div class="header-actions">
        <a href="/degree/create" class="btn btn-primary">+ Add Degree</a>
    </div>
</div>

@if($degrees->count() > 0)
    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Degree Name</th>
                        <th style="width: 140px;">Students</th>
                        <th style="width: 140px;">Courses</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($degrees as $degree)
                    <tr>
                        <td>{{ $degree->id }}</td>
                        <td>{{ $degree->name }}</td>
                        <td><span class="badge badge-primary">{{ $degree->students()->count() }}</span></td>
                        <td><span class="badge badge-success">{{ $degree->courses()->count() }}</span></td>
                        <td>
                            <div class="actions">
                                <a href="/degree/{{ $degree->id }}" class="btn btn-secondary">View</a>
                                <a href="/degree/{{ $degree->id }}/edit" class="btn btn-primary">Edit</a>
                                <form action="/degree/{{ $degree->id }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination Links -->
    @if($degrees->hasPages())
    <div class="pagination-wrapper">
        {{ $degrees->links() }}
    </div>
    @endif
@else
    <div class="empty-state">
        <div class="empty-icon">📚</div>
        <h3>No Degrees Yet</h3>
        <p>Get started by creating your first degree program.</p>
        <a href="/degree/create" class="btn btn-primary">Create Degree</a>
    </div>
@endif

@endsection
