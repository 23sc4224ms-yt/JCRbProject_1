@extends('layouts.app')

@section('content')

    <div class="filters">
        <form method="GET" action="{{ url('/students') }}" style="display:flex; gap:0.5rem; align-items:center; width:100%;">
            <div class="filter-group" style="flex:1;">
                <input type="text" name="q" placeholder="Search name or email" value="{{ request('q') }}" class="filter-input" />
            </div>
            <div class="filter-group">
                <select name="degree_id" class="filter-select">
                    <option value="">All Degrees</option>
                    @foreach($degrees as $degree)
                        <option value="{{ $degree->id }}" @if(request('degree_id') == $degree->id) selected @endif>{{ $degree->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <input type="number" name="age_min" placeholder="Min age" value="{{ request('age_min') }}" class="filter-input" style="width:100px;" />
                <input type="number" name="age_max" placeholder="Max age" value="{{ request('age_max') }}" class="filter-input" style="width:100px;" />
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ url('/students') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Age</th>
                <th>Degree</th>
                <th>Action</th>
            </tr>
        </thead>

        @foreach($students as $student)
        <tr>
            <td>{{ $student->fname }} {{ $student->mname }} {{ $student->lname }}<br></td>
            <td>{{ $student->age }}<br></td>
            <td>{{ $student->degree ? $student->degree->name : 'N/A' }}<br></td>

            <td>
                <div class="action-buttons">
                    <a href="/student/{{ $student->id }}" class="btn btn-info">View</a>
                    <a href="/student/{{ $student->id }}/edit" class="btn btn-primary">Edit</a>
                    <a href="{{ route('student.confirm-delete', $student->id) }}" class="btn btn-danger" onclick="return confirm('Delete {{ $student->fname }}?');">Delete</a>
                </div>
            </td>
        </tr>
        @endforeach

    </table>
    </div>

    <!-- Pagination Links -->
    <div style="margin-top: 20px; display: flex; justify-content: center;">
        {{ $students->links('pagination::bootstrap-4') }}
    </div>

    <div style="display: flex; justify-content: flex-end; margin-top: 15px;">
        <a href="/student/create" class="add-btn">+ Add Student</a>
    </div>

@endsection
