<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stage;
use Illuminate\Http\Request;

class StageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stages = Stage::all();
        return view('admin.stages.index', compact('stages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.stages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Handle image upload if exists
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('stages', 'public');
        }

        // Create a new stage
        Stage::create([
            'name' => $request->name,
            'image' => $imagePath,
        ]);

        return redirect()->route('stages.index')->with('success', 'Stage created successfully.');
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
        $stage = Stage::findOrFail($id);
        return view('admin.stages.edit', compact('stage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $stage = Stage::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Handle image upload if exists
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('stages', 'public');
            $stage->image = $imagePath;
        }

        // Update stage
        $stage->update([
            'name' => $request->name,
        ]);

        return redirect()->route('stages.index')->with('success', 'Stage updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stage = Stage::findOrFail($id);
        $stage->delete();

        return redirect()->route('stages.index')->with('success', 'Stage deleted successfully.');
    }
}
