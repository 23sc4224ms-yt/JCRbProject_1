@extends('layouts.app')

@section('content')

    <div class="card card-filter" style="margin-bottom:1rem;">
        <div class="card-body">
            <form id="student-filter-form" method="GET" action="{{ url('/students') }}" style="display:flex; gap:0.5rem; align-items:center; width:100%;">
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
    </div>

    <div id="student-alert"></div>

    <div class="table-wrapper" style="margin-top:1rem;">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Degree</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="students-table-body">
                @foreach($students as $student)
                <tr id="student-row-{{ $student->id }}">
                    <td>{{ $student->fname }} {{ $student->mname }} {{ $student->lname }}</td>
                    <td>{{ $student->age }}</td>
                    <td>{{ $student->degree ? $student->degree->name : 'N/A' }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="/student/{{ $student->id }}" class="btn btn-info">View</a>
                            <a href="/student/{{ $student->id }}/edit" class="btn btn-primary">Edit</a>
                            <a href="{{ route('student.confirm-delete', $student->id) }}" class="btn btn-danger" onclick="return confirm('Go to delete confirmation page for {{ $student->fname }} {{ $student->lname }}?');">Delete</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="table-pagination" style="margin-top:1rem;">
        {{ $students->onEachSide(1)->links('pagination::bootstrap-4') }}
    </div>

@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
