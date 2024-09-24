<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Stage;
use App\Models\Teacher;
use Hash;
use Illuminate\Http\Request;
use Str;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::with('school', 'stages')->get();
        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schools = School::all();
        $stages = Stage::all();
        return view('admin.teachers.create', compact('schools', 'stages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:teachers',
            'gender' => 'required',
            'school_id' => 'required|exists:schools,id',
            'stage_ids' => 'required|array',
            'stage_ids.*' => 'exists:stages,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $password = Str::random(8);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('teachers', 'public');
        }

        $teacher = Teacher::create([
            'username' => $request->input('username'),
            'password' => Hash::make($password),
            'plain_password' => $password,
            'gender' => $request->input('gender'),
            'school_id' => $request->input('school_id'),
            'is_active' => 1,
            'image' => $imagePath,
        ]);

        $teacher->stages()->attach($request->input('stage_ids'));

        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');

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
        $teacher = Teacher::findOrFail($id);
        $schools = School::all();
        $stages = Stage::all();
        return view('admin.teachers.edit', compact('teacher', 'schools', 'stages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $teacher = Teacher::findOrFail($id);

        $request->validate([
            'username' => 'required|unique:teachers,username,' . $teacher->id,
            'gender' => 'required',
            'school_id' => 'required|exists:schools,id',
            'stage_ids' => 'required|array',
            'stage_ids.*' => 'exists:stages,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('teachers', 'public');
            $teacher->image = $imagePath;
        }

        $teacher->update([
            'username' => $request->input('username'),
            'gender' => $request->input('gender'),
            'school_id' => $request->input('school_id'),
            'is_active' => $request->input('is_active') ?? 1,
        ]);

        // Sync the selected stages
        $teacher->stages()->sync($request->input('stage_ids'));

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}
