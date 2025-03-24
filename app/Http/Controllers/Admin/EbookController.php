<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\Lesson;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class EbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ebooks = Ebook::with('lesson')->get();
        return view('admin.ebooks.index', compact('ebooks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $lessons = Lesson::all();
        $grades = [];
        for ($i = 1; $i <= 10; $i++) {
            $grades[] = 'Grade ' . $i;
        }
        $grades[] = 'demo grade';
        // $grades = Stage::all();
        return view('admin.ebooks.create', compact('grades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_path' => 'required|file|mimes:zip|max:10240',
        ]);

        $file = $request->file('file_path');
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // If it's a zip file, extract it
        if ($isZip) {
            // Store ZIP file in S3 temporarily
            $zipFilePath = $file->store('pyra-public/ebooks', 's3');
            $zipFileName = pathinfo($zipFilePath, PATHINFO_FILENAME);

            // Download the ZIP file from S3 to extract it
            $localZipPath = storage_path("app/temp/$zipFileName.zip");
            Storage::disk('s3')->download($zipFilePath, $localZipPath);

            // Extract ZIP file locally
            $extractPath = storage_path("app/temp/$zipFileName");
            $zip = new ZipArchive;

            if ($zip->open($localZipPath) === TRUE) {
                $zip->extractTo($extractPath);
                $zip->close();

                // Upload extracted files to S3
                foreach (scandir($extractPath) as $file) {
                    if ($file !== '.' && $file !== '..') {
                        Storage::disk('s3')->put("pyra-public/ebooks/$zipFileName/$file", file_get_contents("$extractPath/$file"));
                    }
                }

                // Check if there's an `index.html` file
                $indexHtmlPath = "pyra-public/ebooks/$zipFileName/index.html";
                if (Storage::disk('s3')->exists($indexHtmlPath)) {
                    $filePath = "pyra-public/ebooks/$zipFileName"; // Save extracted folder path
                } else {
                    return back()->withErrors(['file_path' => 'index.html not found in ZIP file.']);
                }

                // Delete the local ZIP file and extracted folder
                unlink($localZipPath);
                Storage::disk('s3')->delete($zipFilePath);
            } else {
                return back()->withErrors(['file_path' => 'Failed to extract the ZIP file.']);
            }
        } else {
            // Store non-zip files (PDF, PPT, etc.) in S3
            $filePath = $file->store('pyra-public/ebooks', 's3');
        }

        // Create the Ebook record in the database
        $ebook = Ebook::create([
            'title' => $fileName,
            'author' => 'Pyramakerz',
            'description' => null,
            'file_path' => $request->grade . '/' . $fileName,
        ]);

        return redirect()->route('ebooks.create')->with('success', 'Ebook created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    public function viewEbook(Ebook $ebook)
    {
        $indexHtmlPath = $ebook->file_path . '/index.html';

        $fileUrl = Storage::disk('s3')->url($indexHtmlPath);

        \Log::info('Looking for index.html at: ' . $fileUrl);

        if (Storage::disk('s3')->exists($indexHtmlPath)) {
            return redirect($fileUrl);
        } else {
            return abort(404, 'Index file not found.');
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ebook = Ebook::findOrFail($id);

        $lessons = Lesson::all();

        return view('admin.ebooks.edit', compact('ebook', 'lessons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ebook $ebook)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx,html,txt,zip|max:10240', // Allow multiple types
            'lesson_id' => 'required|exists:lessons,id',
        ]);
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('pyra-public/ebooks', 's3');
            $ebook->file_path = Storage::disk('s3')->url($filePath);
        }
        $ebook->update([
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description,
            'lesson_id' => $request->lesson_id,
        ]);

        return redirect()->route('ebooks.index')->with('success', 'Ebook updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ebook $ebook)
    {
        $ebook->delete();
        return redirect()->route('ebooks.index')->with('success', 'Ebook deleted successfully.');
    }
}
