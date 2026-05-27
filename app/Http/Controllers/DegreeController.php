<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Degree;
use App\Models\Course;
use App\Models\Teacher;

class DegreeController extends Controller
{
    // Display all degrees
    public function index()
    {
        $this->ensureBsitElectives();
        $degrees = Degree::paginate(5);
        return view('degrees.index', compact('degrees'));
    }

    // Show form for adding a new degree
    public function create()
    {
        return view('degrees.create');
    }

    // Save a new degree to the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Degree::create([
            'name' => $request->name
        ]);

        return redirect('/degree')->with('success', 'Degree created successfully!');
    }

    // Display an individual degree record
    public function show(string $id)
    {
        $this->ensureBsitElectives();
        $degree = Degree::find($id);

        if (!$degree) {
            return redirect('/degree')->with('error', 'Degree not found!');
        }

        $students = $degree->students()->paginate(5);
        $courses = $degree->courses()->with(['teacher', 'students'])->orderBy('name')->get();

        return view('degrees.show', compact('degree', 'students', 'courses'));
    }

    // Show form for editing a degree
    public function edit(string $id)
    {
        $degree = Degree::find($id);

        if (!$degree) {
            return redirect('/degree')->with('error', 'Degree not found!');
        }

        return view('degrees.edit', compact('degree'));
    }

    // Update a degree record
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $degree = Degree::find($id);

        if (!$degree) {
            return redirect('/degree')->with('error', 'Degree not found!');
        }

        $degree->update([
            'name' => $request->name
        ]);

        return redirect('/degree')->with('success', 'Degree updated successfully!');
    }

    // Delete a degree record
    public function destroy(string $id)
    {
        $degree = Degree::find($id);

        if (!$degree) {
            return redirect('/degree')->with('error', 'Degree not found!');
        }

        $degree->delete();

        return redirect('/degree')->with('success', 'Degree deleted successfully!');
    }

    private function ensureBsitElectives(): void
    {
        $degree = Degree::firstOrCreate(['name' => 'BSIT']);
        $teacher = Teacher::first();

        foreach (range(1, 5) as $number) {
            Course::updateOrCreate(
                ['name' => "ELECTIVE {$number}"],
                [
                    'degree_id' => $degree->id,
                    'teacher_id' => $teacher?->id,
                ]
            );
        }
    }
}
