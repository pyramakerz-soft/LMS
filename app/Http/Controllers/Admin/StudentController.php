<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Stage;
use App\Models\Student;
use App\Models\Group;
use App\Models\StudentClass;
use Hash;
use Illuminate\Http\Request;
use Str;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $StudentQuery = Student::with('school', 'stage');

        $schools = School::all();
        $classes = Group::all();

        if($request){
            
            if ($request->has('school') && $request->school != null) {
                $StudentQuery->where('school_id', $request->school);
            }
        
            if ($request->has('class') && $request->class != null) {
                $StudentQuery->where('class_id', $request->class);
            }
        }

        $students = $StudentQuery->get();
        return view('admin.students.index', compact('students', 'schools', 'classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schools = School::all();
        $stages = Stage::all();
        return view('admin.students.create', compact('schools', 'stages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:students',
            'gender' => 'required',
            'school_id' => 'required|exists:schools,id',
            'stage_id' => 'required|exists:stages,id',
            'class_id' => 'required|exists:groups,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $password = Str::random(8);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('students', 'public'); // Save the image to 'storage/app/public/students'
        }

        $student = Student::create([
            'username' => $request->input('username'),
            'password' => Hash::make($password),
            'plain_password' => $password,
            'gender' => $request->input('gender'),
            'school_id' => $request->input('school_id'),
            'stage_id' => $request->input('stage_id'),
            'is_active' => 1,
            'image' => $imagePath,
            'class_id' => $request->class_id,

        ]);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
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
        $student = Student::findOrFail($id);
        $schools = School::all();
        $stages = Stage::all();

        return view('admin.students.edit', compact('student', 'schools', 'stages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'username' => 'required|unique:students,username,' . $student->id,
            'gender' => 'required',
            'school_id' => 'required|exists:schools,id',
            'stage_id' => 'required|exists:stages,id',
            'class_id' => 'required|exists:groups,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('students', 'public');
            $student->image = $imagePath;
        }

        $student->update([
            'username' => $request->input('username'),
            'gender' => $request->input('gender'),
            'school_id' => $request->input('school_id'),
            'stage_id' => $request->input('stage_id'),
            'is_active' => $request->input('is_active') ?? 1,
        ]);
        StudentClass::updateOrCreate(
            ['student_id' => $student->id],
            ['class_id' => $request->class_id]
        );
        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
