<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
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
        $images = Image::all();
        return view("admin.material.create", compact('stages', 'images'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'stage_id' => 'required|exists:stages,id',
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif',
    //         'file_path' => 'required|file|mimes:zip,pdf,docx', 
    //         'how_to_use' => 'required|file|mimes:zip,pdf,docx', 
    //         'learning' => 'required|file|mimes:zip,pdf,docx',
    //         'is_active' => 'nullable|boolean',
    //     ]);

    //     // Handle image upload
    //     $imagePath = null;
    //     if ($request->hasFile('image')) {
    //         $imagePath = $request->file('image')->store('materials', 'public');
    //     }


    //     // Handle file_path (Ebook or zip file handling)
    //     $filePath = null;
    //     $file = $request->file('file_path');
    //     $isZip = $file->getClientOriginalExtension() === 'zip';

    //     if ($isZip) {
    //         $filePath = $file->store('ebooks', 'public');
    //         $extractPath = storage_path('app/public/ebooks/' . pathinfo($filePath, PATHINFO_FILENAME));

    //         $zip = new \ZipArchive;
    //         if ($zip->open(storage_path('app/public/' . $filePath)) === TRUE) {
    //             $zip->extractTo($extractPath);
    //             $zip->close();

    //             $filePath = 'ebooks/' . pathinfo($filePath, PATHINFO_FILENAME);

    //             // Check if the extracted zip contains index.html
    //             if (!file_exists(public_path('storage/' . $filePath . '/index.html'))) {
    //                 return back()->withErrors(['file_path' => 'The extracted zip does not contain index.html.']);
    //             }
    //         } else {
    //             return back()->withErrors(['file_path' => 'Failed to extract the zip file.']);
    //         }
    //     } else {
    //         // For non-zip files
    //         $filePath = $file->store('ebooks', 'public');
    //     }

    //     // Handle how_to_use file upload
    //     $howToUsePath = null;
    //     if ($request->hasFile('how_to_use')) {
    //         $howToUsePath = $request->file('how_to_use')->store('ebooks', 'public');
    //     }

    //     // Handle learning outcomes file upload
    //     $learningPath = null;
    //     if ($request->hasFile('learning')) {
    //         $learningPath = $request->file('learning')->store('ebooks', 'public');
    //     }

    //     // Create a new material with the uploaded data
    //     Material::create([
    //         'title' => $request->title,
    //         'stage_id' => $request->stage_id,
    //         'image' => $imagePath,
    //         'is_active' => $request->is_active ?? 0,
    //         'file_path' => $filePath, // Save the file_path (info) to the material
    //         'how_to_use' => $howToUsePath, // Save how_to_use file path
    //         'learning' => $learningPath, // Save learning outcomes file path
    //     ]);

    //     return redirect()->back()->with('success', 'Material created successfully.');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'stage_id' => 'required|exists:stages,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'existing_image' => 'nullable|string',
            'file_path' => 'required|file|mimes:zip,pdf,ppt,pptx,doc,docx,html,txt|max:10240',
            'how_to_use' => 'required|file|mimes:zip,pdf,ppt,pptx,doc,docx,html,txt|max:10240',
            'learning' => 'required|file|mimes:zip,pdf,ppt,pptx,doc,docx,html,txt|max:10240',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('materials', 'public');
        } elseif ($request->existing_image) {
            $imagePath = $request->existing_image;
        }

        // $imagePath = $request->hasFile('image')
        //     ? $request->file('image')->store('materials', 'public')
        //     : null;

        $filePath = $this->handleFileUpload($request->file('file_path'), 'ebooks');
        if ($filePath === false) {
            return back()->withErrors(['file_path' => 'Failed to extract the zip file or missing index.html.']);
        }
        
        // $howToUsePath = null;
        // $fileHowToUse = $request->file('how_to_use');
        // $isHowToUseZip = $fileHowToUse->getClientOriginalExtension() === 'zip';

        // if ($isHowToUseZip) {
        //     $howToUsePath = $fileHowToUse->store('ebooks', 'public');
        //     $extractPath = storage_path('app/public/ebooks/' . pathinfo($howToUsePath, PATHINFO_FILENAME));

        //     $zip = new \ZipArchive;
        //     if ($zip->open(storage_path('app/public/' . $howToUsePath)) === TRUE) {
        //         $zip->extractTo($extractPath);
        //         $zip->close();

        //         $howToUsePath = 'ebooks/' . pathinfo($howToUsePath, PATHINFO_FILENAME);

        //         // Check if the extracted zip contains index.html
        //         if (!file_exists(public_path('storage/' . $howToUsePath . '/index.html'))) {
        //             return back()->withErrors(['how_to_use' => 'The extracted zip does not contain index.html.']);
        //         }
        //     } else {
        //         return back()->withErrors(['how_to_use' => 'Failed to extract the zip file.']);
        //     }
        // } else {
        //     // For non-zip files
        //     $howToUsePath = $fileHowToUse->store('ebooks', 'public');
        // }
        
        // $learningPath = null;
        // $fileLearning = $request->file('learning');
        // $isLearningZip = $fileLearning->getClientOriginalExtension() === 'zip';

        // if ($isLearningZip) {
        //     $learningPath = $fileLearning->store('ebooks', 'public');
        //     $extractPath = storage_path('app/public/ebooks/' . pathinfo($learningPath, PATHINFO_FILENAME));

        //     $zip = new \ZipArchive;
        //     if ($zip->open(storage_path('app/public/' . $learningPath)) === TRUE) {
        //         $zip->extractTo($extractPath);
        //         $zip->close();

        //         $learningPath = 'ebooks/' . pathinfo($learningPath, PATHINFO_FILENAME);

        //         // Check if the extracted zip contains index.html
        //         if (!file_exists(public_path('storage/' . $learningPath . '/index.html'))) {
        //             return back()->withErrors(['learning' => 'The extracted zip does not contain index.html.']);
        //         }
        //     } else {
        //         return back()->withErrors(['learning' => 'Failed to extract the zip file.']);
        //     }
        // } else {
        //     // For non-zip files
        //     $learningPath = $fileLearning->store('ebooks', 'public');
        // }

        $howToUsePath = $this->handleFileUpload($request->file('how_to_use'), 'ebooks');
        if ($howToUsePath === false) {
            return back()->withErrors(['how_to_use' => 'Failed to extract the zip file or missing index.html.']);
        }

        $learningPath = $this->handleFileUpload($request->file('learning'), 'ebooks');
        if ($learningPath === false) {
            return back()->withErrors(['learning' => 'Failed to extract the zip file or missing index.html.']);
        }

        Material::create([
            'title' => $request->title,
            'stage_id' => $request->stage_id,
            'image' => $imagePath,
            'is_active' => $request->is_active ?? 0,
            'file_path' => $filePath,
            'how_to_use' => $howToUsePath,
            'learning' => $learningPath,
        ]);

        return redirect()->back()->with('success', 'Material created successfully.');
    }

    private function handleFileUpload($file, $storageFolder)
    {
        if ($file->getClientOriginalExtension() === 'zip') {
            $storedPath = $file->store($storageFolder, 'public');
            $extractPath = storage_path('app/public/' . $storageFolder . '/' . pathinfo($storedPath, PATHINFO_FILENAME));

            $zip = new \ZipArchive;
            if ($zip->open(storage_path('app/public/' . $storedPath)) === TRUE) {
                $zip->extractTo($extractPath);
                $zip->close();

                $extractedPath = $storageFolder . '/' . pathinfo($storedPath, PATHINFO_FILENAME);
                if (!file_exists(public_path('storage/' . $extractedPath . '/index.html'))) {
                    return false;
                }
                return $extractedPath;
            } else {
                return false;
            }
        } else {
            return $file->store($storageFolder, 'public');
        }
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
