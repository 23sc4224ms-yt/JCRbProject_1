
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

// Debug route to check APP_ENV
Route::get('/debug-env', function () {
    return response()->json([
        'APP_ENV' => env('APP_ENV'),
        'APP_DEBUG' => env('APP_DEBUG'),
        'APP_MAINTENANCE' => env('APP_MAINTENANCE'),
    ]);
});

Route::get('/login', [UserController::class, 'Login'])->name('login');
Route::post('/login', [UserController::class, 'store'])->name('login.store');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Maintenance page route - accessible without middleware
Route::get('/maintenance', function () {
    return view('maintenance');
})->name('maintenance');

Route::middleware(['session.auth'])->group(function () {
    Route::get('/', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [UserController::class, 'dashboard']);
    Route::get('/about', [StudentController::class, 'studentAbout'])->name('about');

    Route::middleware('role:student|teacher')->group(function () {
        Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('student.password.change');
        Route::post('/change-password', [UserController::class, 'updatePassword'])->name('student.password.update');
    });

    // User profile endpoint
    Route::middleware('role:admin|student|teacher')->group(function () {
        Route::get('/profile', [UserController::class, 'showProfile'])->name('user.profile');
    });

    // Teacher-only routes
    Route::middleware('role:teacher')->group(function () {
        Route::get('/teacher/student-directory', [UserController::class, 'studentDirectory'])->name('teacher.student-directory');
    });

    Route::middleware('role:admin|teacher')->group(function () {
        Route::get('/courses', [UserController::class, 'courses'])->name('teacher.courses');
        Route::get('/courses/{course}', [UserController::class, 'showCourse'])->name('teacher.courses.show');
        Route::post('/courses/{course}/students', [UserController::class, 'addStudentToCourse'])->name('teacher.courses.students.store');
        Route::delete('/courses/{course}/students/{student}', [UserController::class, 'removeStudentFromCourse'])->name('teacher.courses.students.destroy');
    });

    // Admin-only routes
    Route::middleware('role:admin')->group(function () {
        // Custom routes
        Route::get('/student/about', [StudentController::class, 'studentAbout']);
        Route::get('/student/home', [StudentController::class, 'studentHome']);
        Route::get('/studentpage', [StudentController::class, 'studentPage']);

        // Navbar links
        // Success page
        Route::get('/save', function () {
            return view('save');
        });

        // Activity Logs
        Route::get('/activity-logs', [StudentController::class, 'activityLogs'])->name('activity-logs');

        // Teachers list
        Route::get('/teachers', [UserController::class, 'teachersIndex'])->name('teachers.index');

        // API route to get courses by degree
        Route::get('/api/courses/{degree_id}', function ($degree_id) {
            $courses = \App\Models\Course::where('degree_id', $degree_id)->get();
            return response()->json($courses);
        });

        // Admin teacher management
        Route::get('/admin/teachers/create', [UserController::class, 'createTeacher'])->name('admin.teachers.create');
        Route::post('/admin/teachers', [UserController::class, 'storeTeacher'])->name('admin.teachers.store');
        Route::get('/teacher/{id}/delete', [UserController::class, 'confirmDeleteTeacher'])->name('teacher.confirm-delete');
        Route::delete('/teacher/{id}', [UserController::class, 'destroyTeacher'])->name('teacher.destroy');

        // Note: student listing and resource routes are available to admin and teachers (see below)

        // Resource routes for DegreeController
        Route::resource('degree', DegreeController::class);

        // Resource routes for PostController
        Route::resource('posts', PostController::class);
    });

    // Allow teachers and admins to view and manage students
    Route::middleware('role:admin|teacher')->group(function () {
        Route::get('/students', [StudentController::class, 'index']);
        Route::resource('student', StudentController::class);
        Route::get('/student/{id}/delete', [StudentController::class, 'confirmDelete'])->name('student.confirm-delete');
        Route::get('/teacher/add-student', [UserController::class, 'showAddStudentForm'])->name('teacher.add-student');
        Route::post('/teacher/add-student', [UserController::class, 'addStudentToTeacher'])->name('teacher.store-student');
    });
});
