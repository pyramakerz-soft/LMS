<?php
namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Lesson;
use App\Models\School;
use DB;
use Illuminate\Http\Request;
class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lessons = Lesson::all();
        $schools = School::all();
        return view('pages.teacher.assignment.create', compact('lessons', 'schools'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'school_id' => 'required|exists:schools,id',
            'lesson_id' => 'required|exists:lessons,id',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
            'path_file' => 'nullable|file',
            'link' => 'nullable|url',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'marks' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        $filePath = null;
        if ($request->hasFile('path_file')) {
            $filePath = $request->file('path_file')->store('assignments', 'public');
        }
        $assignment = Assignment::create([
            'title' => $request->title,
            'description' => $request->description,
            'path_file' => $filePath,
            'link' => $request->link,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'lesson_id' => $request->lesson_id,
            'school_id' => $request->school_id,
            'marks' => $request->marks,
            'is_active' => $request->is_active ?? 0,
            'teacher_id' => auth()->user()->id,
        ]);
        // Attach students to the assignment
        DB::table('assignment_stage')->insert([
            'assignment_id' => $assignment->id,
            'school_id' => $request->school_id,
            'stage_id' => $request->stage_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        foreach ($request->student_ids as $studentId) {
            DB::table('assignment_student')->insert([
                'assignment_id' => $assignment->id,
                'student_id' => $studentId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        // $assignment->students()->attach($request->student_ids);
        // Assignment::create([
        //     'title' => $request->title,
        //     'description' => $request->description,
        //     'path_file' => $filePath,
        //     'link' => $request->link,
        //     'start_date' => $request->start_date,
        //     'due_date' => $request->due_date,
        //     'lesson_id' => $request->lesson_id,
        //     'school_id' => $request->school_id,
        //     'marks' => $request->marks,
        //     'is_active' => $request->is_active ?? 0,
        // ]);
        return redirect()->route('assignments.index')->with('success', 'Assignment created successfully.');
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
}