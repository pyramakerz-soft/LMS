<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\Lesson;
use Illuminate\Http\Request;

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
        $lessons = Lesson::all();
        return view('admin.ebooks.create', compact('lessons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            // Allow any type of file, including ppt, pdf, html, etc.
            'file_path' => 'required|file|mimes:pdf,ppt,pptx,doc,docx,html,txt,zip|max:10240', // Set max file size to 10MB
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        $filePath = $request->file('file_path')->store('ebooks', 'public'); // Store the file in 'storage/app/public/ebooks'

        Ebook::create([
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description,
            'file_path' => $filePath,
            'lesson_id' => $request->lesson_id,
        ]);

        return redirect()->route('ebooks.index')->with('success', 'Ebook created successfully.');
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
