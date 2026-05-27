<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Degree;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\UserAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function Login(Request $request)
    {
        return response()->view('loginPage')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Handle login submission
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:8',
        ], [
            'username.required' => 'Username is required.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);

        $account = UserAccount::where('username', $validated['username'])->first();

        if ($account && Hash::check($validated['password'], $account->password)) {
            session()->put('user_account_id', $account->id);
            session()->put('username', $account->username);
            session()->put('name', $account->name ?: $account->username);
            session()->put('email', $account->email);
            session()->put('role', $account->role ?: 'student');
            session()->put('force_password_change', (bool) $account->force_password_change);

            if (in_array($account->role, ['student', 'teacher'], true) && $account->force_password_change) {
                return redirect()->route('student.password.change');
            }

            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        return back()->withErrors([
            'username' => 'Invalid username or password.',
        ])->onlyInput('username');
    }

    /**
     * Display the dashboard for the signed in user.
     */
    public function dashboard(Request $request)
    {
        $role = $request->session()->get('role', 'student');
        $forcePasswordChange = (bool) $request->session()->get('force_password_change', false);

        if (in_array($role, ['student', 'teacher'], true) && $forcePasswordChange) {
            return redirect()->route('student.password.change');
        }

        if ($role === 'teacher') {
            $accountId = $request->session()->get('user_account_id');
            $teacher = UserAccount::find($accountId);
            
            // Get enrolled students (either directly assigned or from teacher's degree)
            $enrolledStudents = collect();
            if ($teacher) {
                // Get students directly assigned to teacher
                $enrolledStudents = $teacher->enrolledStudents()->with('degree')->get();
                
                // If teacher has a degree assigned, also get students from that degree
                if ($teacher->degree_id) {
                    $degreeStudents = Student::where('degree_id', $teacher->degree_id)->with('degree')->get();
                    $enrolledStudents = $enrolledStudents->merge($degreeStudents)->unique('id');
                }
            }

            $courses = $this->electiveCourses();
            
            return view('dashboard.teacher', [
                'enrolledStudents' => $enrolledStudents,
                'totalEnrolled' => $enrolledStudents->count(),
                'teacher' => $teacher,
                'courses' => $courses,
            ]);
        }

        return match ($role) {
            'admin' => view('dashboard.admin', [
                'totalStudents' => Student::count(),
                'totalTeachers' => UserAccount::where('role', 'teacher')->count(),
                'totalDegrees' => Degree::count(),
                'courses' => $this->electiveCourses(),
            ]),
            default => view('dashboard.student'),
        };
    }

    public function showChangePasswordForm(Request $request)
    {
        $accountId = $request->session()->get('user_account_id');

        if (!$accountId) {
            return redirect()->route('login');
        }

        $account = UserAccount::find($accountId);

        if (!$account || !in_array($account->role, ['student', 'teacher'], true) || !$account->force_password_change) {
            return redirect()->route('dashboard');
        }

        return view('studentChangePassword');
    }

    public function updatePassword(Request $request)
    {
        $accountId = $request->session()->get('user_account_id');

        if (!$accountId) {
            return redirect()->route('login');
        }

        $account = UserAccount::find($accountId);

        if (!$account || !in_array($account->role, ['student', 'teacher'], true)) {
            return redirect()->route('dashboard');
        }

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Current password is required.',
            'password.required' => 'New password is required.',
            'password.min' => 'New password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        if (!Hash::check($validated['current_password'], $account->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        $account->update([
            'password' => Hash::make($validated['password']),
            'force_password_change' => false,
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Password updated successfully! Please login with your new password.');
    }

    /**
     * Show the current user's profile.
     */
    public function showProfile(Request $request)
    {
        $accountId = $request->session()->get('user_account_id');
        $role = $request->session()->get('role');

        if (!$accountId || !in_array($role, ['admin', 'student', 'teacher'], true)) {
            return redirect()->route('dashboard');
        }

        $account = UserAccount::find($accountId);

        if (!$account) {
            return redirect()->route('login');
        }

        return view('profile', compact('account', 'role'));
    }

    /**
     * Logout the user and clear the current session.
     */
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'You have been logged out.')
            ->withHeaders([
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
    }

    /**
     * Show the form to create a teacher account.
     */
    public function createTeacher()
    {
        return view('admin.createTeacher');
    }

    /**
     * List teachers with optional filters
     */
    public function teachersIndex(Request $request)
    {
        $query = UserAccount::where('role', 'teacher');

        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->where(function($qry) use ($q) {
                $qry->where('name', 'like', "%{$q}%")
                    ->orWhere('username', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $teachers = $query->paginate(10)->appends($request->except('page'));

        return view('teachers.index', compact('teachers'));
    }

    /**
     * Create a teacher account.
     */
    public function storeTeacher(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user_accounts,email',
            'username' => 'required|string|max:255|unique:user_accounts,username',
            'password' => 'required|string|min:8',
        ]);

        UserAccount::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role' => 'teacher',
            'force_password_change' => true,
        ]);

        return redirect()->route('dashboard')->with('success', 'Teacher account created successfully.');
    }

    /**
     * Show the deletion confirmation page for a teacher.
     */
    public function confirmDeleteTeacher(string $id)
    {
        $teacher = UserAccount::where('role', 'teacher')->find($id);
        
        if (!$teacher) {
            return redirect()->route('teachers.index')->with('error', 'Teacher not found!');
        }
        
        return view('teachers.delete', ['teacher' => $teacher]);
    }

    /**
     * Delete a teacher account.
     */
    public function destroyTeacher(string $id)
    {
        $teacher = UserAccount::where('role', 'teacher')->find($id);
        
        if (!$teacher) {
            return redirect()->route('teachers.index')->with('error', 'Teacher not found!');
        }

        $teacherName = $teacher->name;
        $teacher->delete();

        return redirect()->route('teachers.index')->with('success', "Teacher '{$teacherName}' deleted successfully!");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Show student directory for teachers
     */
    public function studentDirectory(Request $request)
    {
        $role = $request->session()->get('role');

        if ($role !== 'teacher') {
            return redirect()->route('dashboard');
        }

        $query = Student::with('degree', 'teacher');

        // Filter by search
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('fname', 'like', "%{$search}%")
                  ->orWhere('mname', 'like', "%{$search}%")
                  ->orWhere('lname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by degree
        if ($request->filled('degree_id')) {
            $query->where('degree_id', $request->input('degree_id'));
        }

        // Filter by age
        if ($request->filled('age_min')) {
            $query->where('age', '>=', $request->input('age_min'));
        }
        if ($request->filled('age_max')) {
            $query->where('age', '<=', $request->input('age_max'));
        }

        $students = $query->paginate(10)->appends($request->except('page'));
        $degrees = Degree::all();

        return view('teacher.student-directory', compact('students', 'degrees'));
    }

    /**
     * Show the form to add a student to a teacher
     */
    public function showAddStudentForm(Request $request)
    {
        $role = $request->session()->get('role');
        if ($role !== 'teacher') {
            return redirect()->route('dashboard');
        }

        $teacher = UserAccount::find($request->session()->get('user_account_id'));
        $availableStudents = Student::where('teacher_id', null)->get();

        return view('teacher.add-student', compact('teacher', 'availableStudents'));
    }

    /**
     * Add a student to a teacher
     */
    public function addStudentToTeacher(Request $request)
    {
        $role = $request->session()->get('role');
        if ($role !== 'teacher') {
            return redirect()->route('dashboard');
        }

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $teacher = UserAccount::find($request->session()->get('user_account_id'));
        $student = Student::find($validated['student_id']);

        if ($student) {
            $student->update(['teacher_id' => $teacher->id]);
            return redirect()->route('dashboard')->with('success', 'Student added successfully!');
        }

        return back()->with('error', 'Student not found.');
    }

    public function courses(Request $request)
    {
        if (!in_array($request->session()->get('role'), ['admin', 'teacher'], true)) {
            return redirect()->route('dashboard');
        }

        $teacher = Teacher::first();
        $courses = $this->electiveCourses();
        $selectedCourse = $courses->first();
        $allStudents = Student::with(['degree', 'courses'])->orderBy('lname')->orderBy('fname')->get();
        $studentCourseRows = $this->studentCourseRows($allStudents);

        return view('teacher.courses', compact('teacher', 'courses', 'selectedCourse', 'allStudents', 'studentCourseRows'));
    }

    public function showCourse(Request $request, Course $course)
    {
        if (!in_array($request->session()->get('role'), ['admin', 'teacher'], true)) {
            return redirect()->route('dashboard');
        }

        $teacher = Teacher::first();
        $courses = $this->electiveCourses();
        $selectedCourse = Course::with(['teacher', 'students.degree'])->findOrFail($course->id);
        $allStudents = Student::with(['degree', 'courses'])->orderBy('lname')->orderBy('fname')->get();
        $studentCourseRows = $this->studentCourseRows($allStudents);

        return view('teacher.courses', compact('teacher', 'courses', 'selectedCourse', 'allStudents', 'studentCourseRows'));
    }

    public function addStudentToCourse(Request $request, Course $course)
    {
        if (!in_array($request->session()->get('role'), ['admin', 'teacher'], true)) {
            return redirect()->route('dashboard');
        }

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $teacher = Teacher::first();
        $course->students()->syncWithoutDetaching([$validated['student_id']]);

        if ($teacher && !$course->teacher_id) {
            $course->update(['teacher_id' => $teacher->id]);
        }

        return redirect()->route('teacher.courses.show', $course)->with('success', 'Student added to course.');
    }

    public function removeStudentFromCourse(Request $request, Course $course, Student $student)
    {
        if (!in_array($request->session()->get('role'), ['admin', 'teacher'], true)) {
            return redirect()->route('dashboard');
        }

        $course->students()->detach($student->id);

        return redirect()->route('teacher.courses.show', $course)->with('success', 'Student removed from course.');
    }

    private function studentCourseRows($students): array
    {
        $rows = [];
        $seen = [];

        foreach ($students as $student) {
            if ($student->courses->isEmpty()) {
                $key = $student->id . ':none';
                if (!isset($seen[$key])) {
                    $rows[] = [
                        'student' => $student,
                        'course' => null,
                    ];
                    $seen[$key] = true;
                }
                continue;
            }

            foreach ($student->courses as $course) {
                $key = $student->id . ':' . $course->id;
                if (isset($seen[$key])) {
                    continue;
                }

                $rows[] = [
                    'student' => $student,
                    'course' => $course,
                ];
                $seen[$key] = true;
            }
        }

        return $rows;
    }

    private function electiveCourses()
    {
        $degree = Degree::firstOrCreate(['name' => 'BSIT']);
        $teacher = UserAccount::where('role', 'teacher')->first();

        foreach (range(1, 5) as $number) {
            $course = Course::updateOrCreate(
                ['name' => "ELECTIVE {$number}"],
                ['degree_id' => $degree->id]
            );

            if (!$course->teacher_id && $teacher) {
                $course->update(['teacher_id' => $teacher->id]);
            }
        }

        return Course::with(['teacher', 'students.degree'])
            ->whereIn('name', ['ELECTIVE 1', 'ELECTIVE 2', 'ELECTIVE 3', 'ELECTIVE 4', 'ELECTIVE 5'])
            ->orderBy('name')
            ->get();
    }
}
