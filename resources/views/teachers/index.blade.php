@extends('layouts.app')

@section('content')

<div class="page-header">
    <div class="header-content">
        <h1>Teachers</h1>
        <p class="header-subtitle">List of teacher accounts</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">+ Add Teacher</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" action="{{ route('teachers.index') }}" class="filters">
            <input type="text" name="q" placeholder="Search name, username or email" value="{{ request('q') }}" class="filter-input" style="flex:1;" />
            <div class="filter-actions">
                <button class="btn btn-primary" type="submit">Filter</button>
                <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <div class="table-wrapper" style="margin-top:1rem;">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $t)
                    <tr>
                        <td>{{ $t->id }}</td>
                        <td>{{ $t->name }}</td>
                        <td>{{ $t->username }}</td>
                        <td>{{ $t->email }}</td>
                        <td>
                            <div class="actions">
                                <a href="#" class="btn btn-secondary btn-sm">View</a>
                                <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                <a href="{{ route('teacher.confirm-delete', $t->id) }}" class="btn btn-danger btn-sm">Delete</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $teachers->links() }}
        </div>
    </div>
</div>

@endsection
