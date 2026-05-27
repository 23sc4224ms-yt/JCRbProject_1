<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Student;
use App\Models\Degree;
use App\Models\ActivityLog;
use App\Models\UserAccount;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function studentAbout() {
        return view("studentAboutPage");
    }

    public function studentHome() {
        $students = Student::with('degree')->get();
        return view("home", compact('students'));
    }

    public function studentPage() {
        return view("studentPage");
    }

    
    public function index()
    {
        $query = Student::with('degree');

        if (request()->filled('q')) {
            $q = request()->get('q');
            $query->where(function($qry) use ($q) {
                $qry->where('fname', 'like', "%{$q}%")
                    ->orWhere('lname', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if (request()->filled('degree_id')) {
            $query->where('degree_id', request()->get('degree_id'));
        }

        if (request()->filled('age_min')) {
            $query->where('age', '>=', (int) request()->get('age_min'));
        }

        if (request()->filled('age_max')) {
            $query->where('age', '<=', (int) request()->get('age_max'));
        }

        $students = $query->paginate(10)->appends(request()->except('page'));

        $degrees = Degree::all();

        if (request()->ajax()) {
            return response()->json([
                'students' => $students->map(function ($student) {
                    return [
                        'id' => $student->id,
                        'fname' => $student->fname,
                        'mname' => $student->mname,
                        'lname' => $student->lname,
                        'age' => $student->age,
                        'degree' => $student->degree ? $student->degree->name : 'N/A',
                    ];
                }),
                'pagination' => [
                    'current_page' => $students->currentPage(),
                    'last_page' => $students->lastPage(),
                    'next_page_url' => $students->nextPageUrl(),
                    'prev_page_url' => $students->previousPageUrl(),
                ],
                'pagination_html' => (string) $students->onEachSide(1)->links('pagination::bootstrap-4'),
            ]);
        }

        return view("students.index", compact('students','degrees'));
    }

   
    public function create()
    {
        $degrees = Degree::all();
        return view('addstudent', ['degrees' => $degrees]);
    }

   
    public function store(Request $request)
    {
        // Validate all input data
        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255', // Middle name is optional
            'lname' => 'required|string|max:255',
            'age' => 'required|numeric|min:16|max:65',
            'degree_id' => 'required|exists:degrees,id',
            'contact' => 'nullable|string|max:20',
            'email' => 'required|email|unique:students,email',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
        ], [
            'fname.required' => 'First name is required.',
            'fname.string' => 'First name must be text.',
            'lname.required' => 'Last name is required.',
            'lname.string' => 'Last name must be text.',
            'age.required' => 'Age is required.',
            'age.min' => 'Age must be at least 16.',
            'age.max' => 'Age cannot exceed 65.',
            'degree_id.required' => 'Please select a degree.',
            'degree_id.exists' => 'Selected degree does not exist.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email.',
            'email.unique' => 'This email is already registered.',
            'contact.max' => 'Contact number is too long.',
            'username.required' => 'Username is required.',
            'username.unique' => 'This username is already taken.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);

        // Create user account first
        $user = User::create([
            'name' => $validated['fname'] . ' ' . $validated['lname'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
        ]);

        // Create the student
        $student = Student::create($validated);

        // Create user account record
        UserAccount::create([
            'name' => $validated['fname'] . ' ' . $validated['lname'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
            'force_password_change' => true,
        ]);

        // Log the activity to database
        ActivityLog::create([
            'student_id' => $student->id,
            'action' => 'created',
            'new_values' => $validated,
            'changes_summary' => "Student '{$student->fname} {$student->lname}' created successfully."
        ]);

        // Log to laravel.log
        Log::info('Student Created', [
            'student_id' => (int)$student->id,
            'name' => (string)"{$student->fname} {$student->lname}",
            'email' => (string)$student->email,
            'age' => (int)$student->age,
            'degree_id' => (int)$student->degree_id
        ]);

        $student->load('degree');

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Student created successfully!',
                'student' => $student,
            ], 201);
        }

        return redirect('/save')->with('success', 'Student created successfully!');
    }


    public function show(string $id)
    {
        
        $student = Student::find($id);

        return view('studentDetails')->with("student", $student);
        
    }

    public function edit(string $id)
    {
        $student = Student::find($id);
        $degrees = Degree::all();
        
        if (!$student) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Student not found!'], 404);
            }

            return redirect('/student')->with('error', 'Student not found!');
        }
        
        return view('editstudent', ['student' => $student, 'degrees' => $degrees]);
    }

    public function confirmDelete(string $id)
    {
        $student = Student::find($id);
        
        if (!$student) {
            return redirect('/students')->with('error', 'Student not found!');
        }
        
        return view('students.delete', ['student' => $student]);
    }

   
    public function update(Request $request, string $id)
    {
        $student = Student::find($id);
        
        if (!$student) {
            return redirect('/student')->with('error', 'Student not found!');
        }

        // Validate all input data
        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'age' => 'required|numeric|min:16|max:65',
            'degree_id' => 'required|exists:degrees,id',
            'contact' => 'nullable|string|max:20',
            'email' => 'required|email|unique:students,email,' . $id,
        ], [
            'fname.required' => 'First name is required.',
            'fname.string' => 'First name must be text.',
            'lname.required' => 'Last name is required.',
            'lname.string' => 'Last name must be text.',
            'age.required' => 'Age is required.',
            'age.min' => 'Age must be at least 16.',
            'age.max' => 'Age cannot exceed 65.',
            'degree_id.required' => 'Please select a degree.',
            'degree_id.exists' => 'Selected degree does not exist.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email.',
            'email.unique' => 'This email is already registered.',
            'contact.max' => 'Contact number is too long.',
        ]);

        // Capture old values before update
        $oldValues = $student->getAttributes();

        // Update the student
        $student->update($validated);

        // Find what changed
        $changes = [];
        foreach ($validated as $key => $value) {
            if ($oldValues[$key] != $value) {
                $changes[$key] = [
                    'old' => $oldValues[$key],
                    'new' => $value
                ];
            }
        }

        // Only log if there were actual changes
        if (!empty($changes)) {
            $changeSummary = "Updated fields: " . implode(', ', array_keys($changes));
            
            ActivityLog::create([
                'student_id' => $student->id,
                'action' => 'updated',
                'old_values' => $oldValues,
                'new_values' => $validated,
                'changes_summary' => $changeSummary
            ]);

            // Log to laravel.log
            Log::info('Student Updated', [
                'student_id' => (int)$student->id,
                'name' => (string)"{$student->fname} {$student->lname}",
                'changes' => (string)$changeSummary,
                'changed_fields' => array_keys($changes)
            ]);
        }
        
        $student->load('degree');

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Student updated successfully!',
                'student' => $student,
            ]);
        }

        return redirect('/save')->with('success', 'Student updated successfully!');
    }

    
    public function destroy(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            if (request()->ajax()) {
                return response()->json(['message' => 'Student not found!'], 404);
            }

            return redirect('/student')->with('error', 'Student not found!');
        }

        // Log deletion before deleting
        ActivityLog::create([
            'student_id' => $student->id,
            'action' => 'deleted',
            'old_values' => $student->getAttributes(),
            'changes_summary' => "Student '{$student->fname} {$student->lname}' deleted."
        ]);

        // Log to laravel.log
        Log::info('Student Deleted', [
            'student_id' => (int)$student->id,
            'name' => (string)"{$student->fname} {$student->lname}",
            'email' => (string)$student->email
        ]);

        $student->delete();

        if (request()->ajax()) {
            return response()->json(['message' => 'Student deleted successfully!']);
        }

        return redirect('/student')->with('success', 'Student deleted successfully!');
    }

    /**
     * Show activity logs
     */
    public function activityLogs(Request $request)
    {
        $query = ActivityLog::with('student');

        // Filter by student if specified
        if ($request->has('student_id') && $request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        // Filter by action type
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Get paginated results, ordered by newest first
        $logs = $query->orderBy('created_at', 'desc')->paginate(10);
        $students = Student::all();

        return view('activityLogs', compact('logs', 'students'));
    }
}
