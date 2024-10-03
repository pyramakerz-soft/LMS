<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Material;
use App\Models\School;
use App\Models\SchoolType;
use App\Models\Stage;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        $totalSchools = School::count();
        $totalTeachers = Teacher::count();
        $totalStudents = Student::count();

        return view('admin.dashboard', compact('totalSchools', 'totalTeachers', 'totalStudents'));
    }
    public function index()
    {
        $schools = School::paginate(10);
        return view('admin.admins.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stages = Stage::all();
        $themes = Material::all();
        $types = Type::get();

        return view('admin.admins.create', compact('stages', 'themes', 'types'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'type_id' => 'required|exists:types,id',
        ]);


        $school = School::create([
            'name' => $request->name,
            'is_active' => 1,
            'address' => $request->address,
            'city' => $request->city,
            'type_id' => $request->type_id,
        ]);


        

        // Admin::create([
        //     'name' => $request->admin_name,
        //     'email' => $request->admin_email,
        //     'password' => Hash::make($request->admin_password),
        //     'role' => 'school_admin',
        //     'school_id' => $school->id, // Assign the newly created school ID
        // ]);

        return redirect()->route('admins.index')->with('success', 'School created successfully.');
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
    public function edit($id)
    {
        $school = School::findOrFail($id);
        $types = Type::all();
        return view('admin.admins.edit', compact('school', 'types'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $school = School::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'type_id' => 'required|exists:types,id',
            'is_active' => 'required|boolean',
        ]);

        // Update school details
        $school->update([
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'type_id' => $request->type_id,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admins.index')->with('success', 'School updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $school = School::findOrFail($id);
        $school->delete();

        return redirect()->route('admins.index')->with('success', 'School deleted successfully.');

    }

    public function viewCurriculum($schoolId)
    {
        $school = School::findOrFail($schoolId);

        // Get all stages for the school
        $stages = $school->stages()->with([
            'materials' => function ($query) use ($schoolId) {
                $query->whereHas('schools', function ($q) use ($schoolId) {
                    $q->where('school_id', $schoolId);
                });
            },
            'materials.units' => function ($query) use ($schoolId) {
                $query->whereHas('schools', function ($q) use ($schoolId) {
                    $q->where('school_id', $schoolId);
                });
            },
            'materials.units.chapters' => function ($query) use ($schoolId) {
                $query->whereHas('schools', function ($q) use ($schoolId) {
                    $q->where('school_id', $schoolId);
                });
            },
            'materials.units.chapters.lessons' => function ($query) use ($schoolId) {
                $query->whereHas('schools', function ($q) use ($schoolId) {
                    $q->where('school_id', $schoolId);
                });
            },
        ])->get();

        return view('admin.schools.view_curriculum', compact('school', 'stages'));
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

        // Validate the request
        $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'material_id' => 'required|exists:materials,id',
            'unit_id' => 'required|exists:units,id',
            'chapter_id' => 'required|exists:chapters,id',
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        // Check if the stage is already assigned to the school
        $isStageAssigned = $school->stages()->wherePivot('stage_id', $request->stage_id)->exists();

        if (!$isStageAssigned) {
            $school->stages()->attach($request->stage_id); // Attach the stage to the school
        }

        // Check if the material is already assigned to the school under this stage
        $isMaterialAssigned = $school->materials()->wherePivot('material_id', $request->material_id)->exists();

        if (!$isMaterialAssigned) {
            $school->materials()->attach($request->material_id);
        }

        // Check if the unit is already assigned to the school under this material
        $isUnitAssigned = $school->units()->wherePivot('unit_id', $request->unit_id)
            ->whereHas('material', function ($query) use ($request) {
                $query->where('material_id', $request->material_id);
            })->exists();

        if (!$isUnitAssigned) {
            $school->units()->attach($request->unit_id);
        }

        // Check if the chapter is already assigned to the school under this unit
        $isChapterAssigned = $school->chapters()->wherePivot('chapter_id', $request->chapter_id)
            ->whereHas('unit', function ($query) use ($request) {
                $query->where('unit_id', $request->unit_id);
            })->exists();

        if (!$isChapterAssigned) {
            $school->chapters()->attach($request->chapter_id);
        }

        // Check if the lesson is already assigned to the school under this chapter
        $isLessonAssigned = $school->lessons()->wherePivot('lesson_id', $request->lesson_id)
            ->whereHas('chapter', function ($query) use ($request) {
                $query->where('chapter_id', $request->chapter_id);
            })->exists();

        if (!$isLessonAssigned) {
            $school->lessons()->attach($request->lesson_id);
        }

        return redirect()->route('admins.index')->with('success', 'Curriculum assigned successfully.');
    }





    public function removeStage($schoolId, $stageId)
    {
        $school = School::findOrFail($schoolId);

        $stage = $school->stages()->find($stageId);

        if ($stage) {
            $stage->materials()->each(function ($material) use ($school) {
                $this->removeMaterial($school->id, $material->id);
            });

            $school->stages()->detach($stageId);
        }

        return redirect()->back()->with('success', 'Stage and its related curriculum removed successfully.');
    }

    public function removeMaterial($schoolId, $materialId)
    {
        $school = School::findOrFail($schoolId);

        $material = $school->materials()->find($materialId);

        if ($material) {
            $material->units()->each(function ($unit) use ($school) {
                $this->removeUnit($school->id, $unit->id);
            });

            $school->materials()->detach($materialId);
        }

        return redirect()->back()->with('success', 'Material and its related curriculum removed successfully.');
    }

    public function removeUnit($schoolId, $unitId)
    {
        $school = School::findOrFail($schoolId);

        $unit = $school->units()->find($unitId);

        if ($unit) {
            $unit->chapters()->each(function ($chapter) use ($school) {
                $this->removeChapter($school->id, $chapter->id);
            });

            $school->units()->detach($unitId);
        }

        return redirect()->back()->with('success', 'Unit and its related curriculum removed successfully.');
    }

    public function removeChapter($schoolId, $chapterId)
    {
        $school = School::findOrFail($schoolId);

        $chapter = $school->chapters()->find($chapterId);

        if ($chapter) {
            $chapter->lessons()->each(function ($lesson) use ($school) {
                $this->removeLesson($school->id, $lesson->id);
            });

            $school->chapters()->detach($chapterId);
        }

        return redirect()->back()->with('success', 'Chapter and its related curriculum removed successfully.');
    }

    public function removeLesson($schoolId, $lessonId)
    {
        $school = School::findOrFail($schoolId);

        $lesson = $school->lessons()->find($lessonId);

        if ($lesson) {
            $school->lessons()->detach($lessonId);
        }

        return redirect()->back()->with('success', 'Lesson removed successfully.');
    }







}
