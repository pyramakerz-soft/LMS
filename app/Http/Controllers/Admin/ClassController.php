<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\School;
use App\Models\Stage;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = Group::all();
        return view('admin.classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schools = School::all();
        $stages = Stage::all();
        return view('admin.classes.create', compact('schools', 'stages'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'school_id' => 'required|exists:schools,id',
            'stage_id' => 'required|exists:stages,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('classes', 'public');
        }
        $class = Group::create([
            'name' => $request->input('name'),
            'school_id' => $request->input('school_id'),
            'stage_id' => $request->input('stage_id'),
            'image' => $imagePath,
        ]);

        return redirect()->route('classes.index')->with('success', 'Class created successfully.');
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
        $class = Group::findOrFail($id);
        $schools = School::all();
        $stages = Stage::all();

        return view('admin.classes.edit', compact('class', 'schools', 'stages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $class = Group::findOrFail($id);

        $request->validate([
            'name' => 'required' . $class->id,
            'school_id' => 'required|exists:schools,id',
            'stage_id' => 'required|exists:stages,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('classes', 'public');
            $class->image = $imagePath;
        }

        $class->update([
            'name' => $request->input('name'),
            'school_id' => $request->input('school_id'),
            'stage_id' => $request->input('stage_id'),
        ]);

        return redirect()->route('classes.index')->with('success', 'Class updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $class = Group::findOrFail($id);
        $class->delete();
        return redirect()->route('classes.index')->with('success', 'Class deleted successfully.');

    }
}