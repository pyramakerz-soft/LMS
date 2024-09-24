<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Stage;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::all();
        return view("admin.material.index", compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stages = Stage::all();

        return view("admin.material.create", compact('stages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'stage_id' => 'required|exists:stages,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'is_active' => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('materials', 'public');
        }

        // Create a new material
        Material::create([
            'title' => $request->title,
            'stage_id' => $request->stage_id,
            'image' => $imagePath,
            'is_active' => $request->is_active ?? 0,
        ]);

        return redirect()->back()->with('success', 'Material created successfully.');
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
        $material = Material::findOrFail($id);
        $stages = Stage::all();
        return view("admin.material.edit", compact('material', 'stages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $material = Material::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'stage_id' => 'required|exists:stages,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('materials', 'public');

            $material->image = $imagePath;
        }

        // Update the material
        $material->update([
            'title' => $request->title,
            'stage_id' => $request->stage_id,
            'is_active' => $request->is_active ?? 0,
        ]);

        return redirect()->route('material.index')->with('success', 'Material updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->route('material.index')->with('success', 'Material deleted successfully.');
    }
}
