<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Material;
use App\Models\Stage;
use App\Models\Unit;
use Auth;
use Illuminate\Http\Request;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::guard('teacher')->user();

        $stages = Stage::whereHas('teachers', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->whereHas('schools', function ($query) use ($teacher) {
            $query->where('school_id', $teacher->school_id);
        })->with('materials')->get();
        return view('pages.teacher.teacher', compact('stages'));
    }

    public function showMaterials($stageId)
    {
        $teacher = Auth::guard('teacher')->user();

        // Get the stage with materials and ensure it belongs to the teacher's school and the stage is assigned to the teacher
        $stage = Stage::where('id', $stageId)
            ->whereHas('teachers', function ($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })
            ->whereHas('schools', function ($query) use ($teacher) {
                $query->where('school_id', $teacher->school_id);
            })
            ->with('materials')
            ->firstOrFail();

        return view('pages.teacher.teacherTheme', compact('stage'));
    }

    // Fetch and display units related to the material
    public function showUnits($materialId)
    {
        $material = Material::with('units.chapters')->findOrFail($materialId);
        dd($material);

        return view('pages.teacher.units', compact('material'));
    }
    public function showChapters($unitId)
    {
        // Fetch unit with related chapters
        $unit = Unit::with('chapters')->findOrFail($unitId);

        return view('pages.teacher.chapters', compact('unit'));
    }
    public function showLessons($chapterId)
    {
        // Fetch chapter with related lessons
        $chapter = Chapter::with('lessons')->findOrFail($chapterId);


        return view('pages.teacher.lessons', compact('chapter'));
    }
    public function changeName()
    {
        $teacher = Auth::guard('teacher')->user();
        $teacher->username = request()->username;
        $teacher->save();
        return redirect()->back();
    }
}
