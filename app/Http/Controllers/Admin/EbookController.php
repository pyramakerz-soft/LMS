<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\Lesson;
use App\Models\Stage;
use Illuminate\Http\Request;
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

        $extractPath = public_path('ebooks/' . $request->grade . '/');
        // dd($extractPath);

        if (!file_exists($extractPath)) {
            mkdir($extractPath, 0777, true);
        }

        $zip = new ZipArchive;
        if ($zip->open($request->file('file_path')->path()) === TRUE) {
            $zip->extractTo($extractPath);
            $zip->close();
        } else {
            return back()->withErrors(['file_path' => 'Failed to open the ZIP file.']);
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
        // Ensure that $ebook->file_path contains only the relative path
        $relativePath = 'storage/' . $ebook->file_path . '/index.html'; // Correct path for web

        // Construct the URL to the index.html file
        $fileUrl = asset($relativePath); // This creates a public URL

        // Debugging: log the URL
        \Log::info('Looking for index.html at: ' . $fileUrl);

        // Check if the file exists in the storage path
        if (file_exists(public_path($relativePath))) {
            return redirect($fileUrl); // Redirect to the file URL for viewing
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
            $filePath = $request->file('file_path')->store('ebooks', 'public');
            $ebook->file_path = $filePath;
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
