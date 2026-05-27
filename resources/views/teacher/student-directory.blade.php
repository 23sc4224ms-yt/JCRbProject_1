@extends('layouts.app')

@section('title', 'Student Directory')

@section('content')
    <div class="page-header mb-4">
        <div>
            <h1 class="page-header-title">Student Directory</h1>
            <p class="page-header-subtitle">Browse all students by degree, age, or search criteria</p>
        </div>
    </div>

    <div class="card card-filter" style="margin-bottom: 1rem;">
        <div class="card-body">
            <form method="GET" action="{{ route('teacher.student-directory') }}" style="display:flex; gap:0.5rem; align-items:center; width:100%; flex-wrap: wrap;">
                <div class="filter-group" style="flex:1; min-width: 200px;">
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
                    <a href="{{ route('teacher.student-directory') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="table-wrapper" style="margin-top: 1rem;">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Degree</th>
                    <th>Email</th>
                    <th>Contact</th>
                </tr>
            </thead>
            <tbody>
                @if ($students->count() > 0)
                    @foreach($students as $student)
                    <tr>
                        <td>{{ $student->fname }} {{ $student->mname }} {{ $student->lname }}</td>
                        <td>{{ $student->age }}</td>
                        <td>{{ $student->degree ? $student->degree->name : 'N/A' }}</td>
                        <td>{{ $student->email ?? 'N/A' }}</td>
                        <td>{{ $student->contact ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 2rem; color: #64748b;">
                            <i class="fas fa-search"></i> No students found matching your criteria.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper" style="margin-top: 1rem;">
        {{ $students->onEachSide(1)->links('pagination::bootstrap-4') }}
    </div>
@endsection
