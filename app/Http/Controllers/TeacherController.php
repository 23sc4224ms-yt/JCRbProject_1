<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\UserAccount;
use App\Models\Degree;

class TeacherController extends Controller
{
    /**
     * Show the teacher dashboard
     */
    public function dashboard(Request $request)
    {
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
        
        return view('dashboard.teacher', [
            'enrolledStudents' => $enrolledStudents,
            'totalEnrolled' => $enrolledStudents->count(),
            'teacher' => $teacher,
        ]);
    }

    /**
     * Show the form to add a student
     */
    public function showAddStudentForm(Request $request)
    {
        $teacher = UserAccount::find($request->session()->get('user_account_id'));
        $availableStudents = Student::where('teacher_id', null)->get();

        return view('teacher.add-student', compact('teacher', 'availableStudents'));
    }

    /**
     * Add a student to a teacher
     */
    public function addStudentToTeacher(Request $request)
    {
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

    /**
     * Show student directory for teachers
     */
    public function studentDirectory(Request $request)
    {
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
     * View a specific student's details
     */
    public function viewStudent($id)
    {
        $student = Student::with('degree', 'teacher', 'activityLogs')->findOrFail($id);
        return view('teacher.student-detail', compact('student'));
    }
}

