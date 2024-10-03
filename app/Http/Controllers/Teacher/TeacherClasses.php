<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\TeacherClass;
use Illuminate\Http\Request;

class TeacherClasses extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userAuth = auth()->guard('teacher')->user();
        if ($userAuth) {
            $classesTeachers = TeacherClass::where('teacher_id', $userAuth->id)->get();


            return view('pages.teacher.Class.index', compact('classesTeachers', "userAuth"));
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
