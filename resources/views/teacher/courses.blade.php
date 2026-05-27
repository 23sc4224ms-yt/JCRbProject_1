@extends('layouts.app')

@section('title', 'Courses')

@php
    $enrolledIds = $selectedCourse ? $selectedCourse->students->pluck('id')->all() : [];
@endphp

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-header-title">Course</h1>
            <p class="page-header-subtitle">Click an elective to view teacher and enrolled students.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Dashboard</a>
    </div>

    <div class="course-workspace">
        <aside class="course-list-panel">
            <h2>List Course</h2>
            <div class="course-list">
                @foreach($courses as $course)
                    <a href="{{ route('teacher.courses.show', $course) }}" class="course-list-item @if($selectedCourse && $selectedCourse->id === $course->id) active @endif">
                        <span>{{ $course->name }}</span>
                        <small>{{ $course->students->count() }} enrolled</small>
                    </a>
                @endforeach
            </div>
        </aside>

        <section class="course-detail-panel">
            <div class="course-detail-header">
                <div>
                    <h2>{{ $selectedCourse?->name ?? 'No Course' }}</h2>
                    <p>Teacher: <strong>{{ $selectedCourse?->teacher?->name ?? $teacher?->name ?? 'No teacher assigned' }}</strong></p>
                </div>
                @if($selectedCourse)
                    <form action="{{ route('teacher.courses.students.store', $selectedCourse) }}" method="POST" class="inline-add-form">
                        @csrf
                        <select name="student_id" class="form-control" required>
                            <option value="">Add student</option>
                            @foreach($allStudents as $student)
                                @if(!in_array($student->id, $enrolledIds, true))
                                    <option value="{{ $student->id }}">{{ $student->fname }} {{ $student->lname }}</option>
                                @endif
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
                    </form>
                @endif
            </div>

            <div class="course-student-table">
                <table>
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Teacher</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($selectedCourse?->students ?? [] as $student)
                            <tr>
                                <td>{{ $student->fname }} {{ $student->mname }} {{ $student->lname }}</td>
                                <td>{{ $selectedCourse->name }}</td>
                                <td>{{ $selectedCourse->teacher?->name ?? $teacher?->name ?? 'No teacher assigned' }}</td>
                                <td>
                                    <form action="{{ route('teacher.courses.students.destroy', [$selectedCourse, $student]) }}" method="POST" style="margin:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-xmark"></i> Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="color:#64748b;font-weight:600;">No enrolled students for this course yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <div class="card compact-card" style="margin-top:1rem;">
        <div class="card-body">
            <div class="section-heading">
                <h2>Student Course Output</h2>
                <span style="color:#64748b;font-weight:700;font-size:.8rem;">Each student can take one or many courses</span>
            </div>
            @php
                $studentCourseRows = $studentCourseRows ?? [];
                $uniqueRows = collect($studentCourseRows)
                    ->groupBy(function ($row) {
                        $student = $row['student'];
                        $name = trim(($student->fname ?? '') . ' ' . ($student->mname ?? '') . ' ' . ($student->lname ?? ''));

                        return strtolower($name);
                    })
                    ->map(function ($rows) {
                        $withCourse = $rows->first(function ($row) {
                            return !empty($row['course']);
                        });

                        return $withCourse ?? $rows->first();
                    })
                    ->values();
            @endphp
            <div class="course-student-table">
                <table>
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Course</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($uniqueRows as $row)
                            <tr>
                                <td>{{ $row['student']->fname }} {{ $row['student']->mname }} {{ $row['student']->lname }}</td>
                                <td>{{ $row['course']?->name ?? 'No course enrolled' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" style="color:#64748b;font-weight:600;">No students yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
