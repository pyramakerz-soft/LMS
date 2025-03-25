<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Material;
use App\Models\MaterialResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use ZipArchive;

class MaterialResourceController extends Controller
{
    public function index(Request $request) {}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $lessons = Lesson::query()->with('chapter.unit.material')->get();
        // $lessons = Lesson::query()
        //     ->with('chapter.unit.material')
        //     ->get()
        //     ->sortBy(fn($lesson) => $lesson->chapter?->unit?->material?->id ?? '');

        $themes = Material::all();



        return view('admin.theme_resources.create', compact('themes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'theme_id' => 'required|exists:materials,id',
            'file_path' => 'required|file|max:204800',
        ]);

        $file = $request->file('file_path');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = 'material_resources/' . $fileName;
        $fileType = $file->getClientOriginalExtension();

        $file->move(public_path('material_resources'), $fileName);

        MaterialResource::create([
            'material_id' => $request->theme_id,
            'title' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'path' => $filePath,
            'type' => $fileType,
        ]);

        return redirect()->back()->with('success', 'Material resource uploaded successfully.');
    }
    public function download(Request $request)
    {
        $resources = MaterialResource::where('material_id', $request->download_theme_id)->get();

        if ($resources->isEmpty()) {
            return redirect()->back()->with('error', 'No resources available for this theme.');
        }
        $material = Material::query()->where('id', $request->download_theme_id)->first();

        $zipFileName =  $material->title . '_resources.zip';
        $zipPath = public_path('material_resources/' . $zipFileName);

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($resources as $resource) {
                $filePath = public_path($resource->path);
                if (File::exists($filePath)) {
                    $zipFileName = $resource->title . '.' . $resource->type;
                    $zip->addFile($filePath, $zipFileName);
                }
            }
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
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
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $student_id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {}
}
