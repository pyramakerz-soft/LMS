<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::with('material')->get(); // Get all units with their associated materials
        return view('admin.units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $materials = Material::all(); // Fetch all materials for the dropdown
        return view('admin.units.create', compact('materials'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'material_id' => 'required|exists:materials,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload if exists
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('units', 'public');
        }

        // Create a new unit
        Unit::create([
            'title' => $request->title,
            'material_id' => $request->material_id,
            'image' => $imagePath,
            'is_active' => $request->is_active ?? 0,
        ]);

        return redirect()->route('units.index')->with('success', 'Unit created successfully.');
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
        $unit = Unit::findOrFail($id);
        $materials = Material::all(); // Fetch all materials for the dropdown
        return view('admin.units.edit', compact('unit', 'materials'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $unit = Unit::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'material_id' => 'required|exists:materials,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload if exists
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('units', 'public');
            $unit->image = $imagePath;
        }

        // Update the unit
        $unit->update([
            'title' => $request->title,
            'material_id' => $request->material_id,
            'is_active' => $request->is_active ?? 0,
        ]);

        return redirect()->route('units.index')->with('success', 'Unit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        return redirect()->route('units.index')->with('success', 'Unit deleted successfully.');
    }
}