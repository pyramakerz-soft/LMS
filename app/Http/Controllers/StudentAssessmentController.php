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
        $teacher = Auth::user();

        $students = Student::with(['studentAssessment' => function($query) {
            $query->latest(); // Fetch the latest assessment for each student
        }])->get();
    
        return view('pages.teacher.assessments.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get the authenticated teacher
        $teacher = Auth::user();

        $students = Student::where('school_id', $teacher->school_id)
            ->whereIn('stage_id', $teacher->stages->pluck('id'))
            ->get();

        return view('pages.teacher.assessments.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */ public function store(Request $request)
    {
        $request->validate([
            'assessments' => 'required|array',
            'assessments.*.student_id' => 'required|exists:students,id',
            'assessments.*.attendance_score' => 'nullable|integer|min:0|max:10',
            'assessments.*.classroom_participation_score' => 'nullable|integer|min:0|max:15',
            'assessments.*.classroom_behavior_score' => 'nullable|integer|min:0|max:15',
            'assessments.*.homework_score' => 'nullable|integer|min:0|max:10',
            'assessments.*.final_project_score' => 'nullable|integer|min:0|max:50',
        ]);

        $today = now()->toDateString(); // Get the current date

        foreach ($request->assessments as $assessmentData) {
            // Check if an assessment has already been created today for this student
            $existingAssessment = Student_assessment::where('student_id', $assessmentData['student_id'])
                ->whereDate('created_at', $today) // Only look at assessments from today
                ->first();

            if ($existingAssessment) {
                // Skip creating another assessment if one already exists for today
                continue;
            }

            // Create a new assessment for the student if no assessment exists for today
            Student_assessment::create([
                'student_id' => $assessmentData['student_id'],
                'teacher_id' => Auth::id(), // The logged-in teacher
                'attendance_score' => $assessmentData['attendance_score'] ?? 0,
                'classroom_participation_score' => $assessmentData['classroom_participation_score'] ?? 0,
                'classroom_behavior_score' => $assessmentData['classroom_behavior_score'] ?? 0,
                'homework_score' => $assessmentData['homework_score'] ?? 0,
                'final_project_score' => $assessmentData['final_project_score'] ?? 0,
            ]);
        }

        return redirect()->route('assessments.index')->with('success', 'Assessments added successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function showStudentAssessments($student_id)
    {
        // Get the student
        $student = Student::findOrFail($student_id);

        // Fetch all previous assessments for this student
        $assessments = Student_assessment::where('student_id', $student_id)->get();

        return view('pages.teacher.assessments.student', compact('student', 'assessments'));
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
    public function update(Request $request, string $student_id)
    {
        $request->validate([
            'attendance_score' => 'nullable|integer|min:0|max:10',
            'classroom_participation_score' => 'nullable|integer|min:0|max:15',
            'classroom_behavior_score' => 'nullable|integer|min:0|max:15',
            'homework_score' => 'nullable|integer|min:0|max:10',
            'final_project_score' => 'nullable|integer|min:0|max:50',
        ]);

        // Find or create the assessment
        $assessment = Student_assessment::firstOrCreate([
            'student_id' => $student_id,
            'teacher_id' => Auth::id(), // Current teacher's ID
        ]);

        // Update the assessment with the new scores
        $assessment->update($request->only([
            'attendance_score',
            'classroom_participation_score',
            'classroom_behavior_score',
            'homework_score',
            'final_project_score'
        ]));

        return redirect()->back()->with('success', 'Assessment updated successfully!');
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