<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Stage;
use App\Models\TeacherResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherResourceController extends Controller
{

    public function index()
    {
        $resources = TeacherResource::with('stage', 'school')->get();
        return view('admin.teacher_resources.index', compact('resources'));
    }

    public function create()
    {
        $stages = Stage::all();
        $schools = School::all();
        return view('admin.teacher_resources.create', compact('stages', 'schools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'file_path' => 'nullable|mimes:pdf',
            'stage_id' => 'required|exists:stages,id',
            'school_id' => 'required|exists:schools,id',
            'type' => 'required|in:pdf,ebook',

        ]);

        if ($request->hasFile('image')) {
            // Store image in S3 inside 'pyra-public/teacher_resources/' folder
            $imagePath = $request->file('image')->store('pyra-public/teacher_resources', 's3');

            // Convert the path to a full S3 URL
            $imagePath = Storage::disk('s3')->url($imagePath);
        }

        // Store file in S3 inside 'pyra-public/teacher_resources/' folder
        $filePath = $request->file('file_path')->store('pyra-public/teacher_resources', 's3');

        // Convert the path to a full S3 URL
        $filePath = Storage::disk('s3')->url($filePath);

        TeacherResource::create([
            'name' => $request->name,
            'image' => $imagePath,
            'file_path' => $filePath,
            'stage_id' => $request->stage_id,
            'school_id' => $request->school_id,
            'type' => $request->type,
        ]);

        return redirect()->route('teacher_resources.index')->with('success', 'Resource added successfully.');
    }

    public function destroy($id)
    {
        $resource = TeacherResource::findOrFail($id);
        $resource->delete();

        return redirect()->route('teacher_resources.index')->with('success', 'Resource deleted successfully.');
    }
}
