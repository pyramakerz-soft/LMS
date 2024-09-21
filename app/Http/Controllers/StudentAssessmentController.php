<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Student_assessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // Fetch students with their related assessments
        $students = Student::with('studentAssessment')->get();
        return view('pages.teacher.assessments.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all(); // Fetch all students
        return view('pages.teacher.assessments.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'attendance_score' => 'nullable|integer|max:10',
            'classroom_participation_score' => 'nullable|integer|max:15',
            'classroom_behavior_score' => 'nullable|integer|max:15',
            'homework_score' => 'nullable|integer|max:10',
            'final_project_score' => 'nullable|integer|max:50',
        ]);

        Student_assessment::create([
            'student_id' => $request->student_id,
            'teacher_id' => Auth::id(),
            'attendance_score' => $request->attendance_score,
            'classroom_participation_score' => $request->classroom_participation_score,
            'classroom_behavior_score' => $request->classroom_behavior_score,
            'homework_score' => $request->homework_score,
            'final_project_score' => $request->final_project_score,
        ]);

        return redirect()->route('teacher.assessments.index')->with('success', 'Assessment added successfully.');
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
        $assessment = Student_assessment::findOrFail($id);
        $students = Student::all();
        return view('teacher.assessments.edit', compact('assessment', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'attendance_score' => 'nullable|integer|max:10',
            'classroom_participation_score' => 'nullable|integer|max:15',
            'classroom_behavior_score' => 'nullable|integer|max:15',
            'homework_score' => 'nullable|integer|max:10',
            'final_project_score' => 'nullable|integer|max:50',
        ]);

        $assessment = Student_assessment::findOrFail($id);
        $assessment->update([
            'student_id' => $request->student_id,
            'attendance_score' => $request->attendance_score,
            'classroom_participation_score' => $request->classroom_participation_score,
            'classroom_behavior_score' => $request->classroom_behavior_score,
            'homework_score' => $request->homework_score,
            'final_project_score' => $request->final_project_score,
        ]);

        return redirect()->route('teacher.assessments.index')->with('success', 'Assessment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $assessment = Student_assessment::findOrFail($id);
        $assessment->delete();
        return redirect()->route('teacher.assessments.index')->with('success', 'Assessment deleted successfully.');
    }
}
