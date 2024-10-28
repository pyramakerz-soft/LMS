<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

class TeacherResources extends Controller
{

    public function resourcesForTeacher($stageId)
    {
        $user = auth()->guard('teacher')->user();

        $isStageAssigned = $user->stages()->where('stage_id', $stageId)->exists();

        if (!$isStageAssigned) {
            return back()->withErrors(['error' => 'You are not assigned to this stage.']);
        }

        $resources = \App\Models\TeacherResource::where('school_id', $user->school_id)
            ->where('stage_id', $stageId)
            ->get();

        $pdfResources = $resources->filter(function ($resource) {
            return Str::endsWith($resource->file_path, ['.pdf']);
        });

        $ebookResources = $resources->filter(function ($resource) {
            return Str::endsWith($resource->file_path, ['.epub', '.mobi', '.html']);
        });

        return view('pages.teacher.resources.index', compact('pdfResources', 'ebookResources'));
    }
}
