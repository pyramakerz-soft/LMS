<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\School;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::where('role', 'school_admin')->with('school')->get(); // Fetch school admins with their schools
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // Validation for School fields
            'school_name' => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'type' => 'required|in:international,national',

            // Validation for Admin (School Admin) fields
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:admins,email',
            'admin_password' => 'required|string|min:6|confirmed',
        ]);

        // First, create the school
        $school = School::create([
            'name' => $request->school_name,
            'is_active' => $request->is_active,
            'address' => $request->address,
            'city' => $request->city,
            'type' => $request->type,
        ]);

        // Then, create the school admin and assign the school_id
        Admin::create([
            'name' => $request->admin_name,
            'email' => $request->admin_email,
            'password' => Hash::make($request->admin_password),
            'role' => 'school_admin',
            'school_id' => $school->id, // Assign the newly created school ID
        ]);

        return redirect()->route('admins.index')->with('success', 'School and School Admin created successfully.');
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
        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:admins,email,' . $admin->id,
            'admin_password' => 'nullable|string|min:6|confirmed',
        ]);

        $admin->update([
            'name' => $request->admin_name,
            'email' => $request->admin_email,
            'password' => $request->admin_password ? Hash::make($request->admin_password) : $admin->password,
        ]);

        return redirect()->route('admins.index')->with('success', 'School Admin updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admins.index')->with('success', 'School Admin deleted successfully.');
    }

    public function viewCurriculum($schoolId)
    {
        $school = School::with('stages.materials.units.chapters.lessons')->findOrFail($schoolId);

        $curriculum = $school->stages()->with('materials.units.chapters.lessons')->get();

        return view('admin.schools.view_curriculum', compact('school', 'curriculum'));
    }

    public function assignCurriculum($schoolId)
    {
        $school = School::findOrFail($schoolId);
        $stages = Stage::all();
        return view('admin.schools.curriculum', compact('school', 'stages'));
    }

    public function storeCurriculum(Request $request, $schoolId)
    {
        $school = School::findOrFail($schoolId);

        // Store the assigned curriculum to the school
        $school->stages()->attach($request->stage_id);
        $school->materials()->attach($request->material_id);
        $school->units()->attach($request->unit_id);
        $school->chapters()->attach($request->chapter_id);
        $school->lessons()->attach($request->lesson_id);

        return redirect()->route('admins.index')->with('success', 'Curriculum assigned successfully.');
    }
}
