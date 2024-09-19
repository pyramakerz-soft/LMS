<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Stage;
use App\Models\Student;
use Hash;
use Illuminate\Http\Request;
use Str;

class StudentController extends Controller
{
    public function create()
    {
        $schools = School::all();
        $stages = Stage::all();

        return view('students.create', compact('schools', 'stages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:students',
            'gender' => 'required',
            'school_id' => 'required|exists:schools,id',
            'stage_id' => 'required|exists:stages,id',
        ]);

        $password = Str::random(8);

        $student = Student::create([
            'username' => $request->input('username'),
            'password' => Hash::make($password),
            'plain_password' => $password, 
            'gender' => $request->input('gender'),
            'school_id' => $request->input('school_id'),
            'stage_id' => $request->input('stage_id'),
            'is_active' => 1,
            'image' => $request->input('image') ?? null, 
        ]);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function index(Request $request)
    {
        $students = Student::with('school', 'stage')->get();
    
        return view('students.index', compact('students'));
    }
}
