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
    public function students(string $class_id)
    {
        $userAuth = auth()->guard('teacher')->user();

        if ($userAuth) {
            $class = TeacherClass::with('students')->where('class_id', $class_id)->where('teacher_id', $userAuth->id)->first();

            if (!$class) {
                return redirect()->route('teacher_classes')->withErrors(['error' => 'Class not found or unauthorized access.']);
            }

            $students = $class->students;

            return view('pages.teacher.Class.students', compact('students', 'class'));
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
