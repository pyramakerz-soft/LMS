<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\School;
use App\Models\Stage;
use App\Models\Teacher;
use App\Models\TeacherClass;
use Hash;
use Illuminate\Http\Request;
use Str;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $teacherQuery = Teacher::with('school')->whereNull('alias_id');

        $schools = School::all();

        if ($request->has('school') && $request->school != null) {
            $teacherQuery->where('school_id', $request->school);
        }

        $teachers = $teacherQuery->paginate(10)->appends($request->query());

        return view('admin.teachers.index', compact('teachers', 'schools'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schools = School::all();
        $stages = Stage::all();
        return view('admin.teachers.create', compact('schools', 'stages'));
    }
    public function addSchool(string $id)
    {
        $mainteacher = Teacher::findOrFail($id);
        $schools = School::all();
        $stages = Stage::all();
        $teacherAlias = Teacher::where('alias_id', $mainteacher->id)->get();
        return view('admin.teachers.add_school', compact('mainteacher', 'teacherAlias', 'schools', 'stages'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function storeSchool(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'stage_ids' => 'required|array',
            'stage_ids.*' => 'exists:stages,id',
            'class_id' => 'required|array',
            'class_id.*' => 'exists:groups,id'
        ]);
        $existingTeacher = Teacher::find($request->mainteacher);
        $school = School::find($request->school_id);
        $username = $existingTeacher->username . '_' . $school->name;
        $existingTeacherSchool  = Teacher::where('username', $username)->get();
        if ($existingTeacherSchool->count() > 0) {
            return redirect()->back()->with('error', 'Teacher already added to this school.');
        }
        $teacher = Teacher::create([
            'username' => $username,
            'password' => Hash::make($existingTeacher->plain_password),
            'plain_password' => $existingTeacher->plain_password,
            'gender' => $existingTeacher->gender,
            'school_id' => $request->input('school_id'),
            'is_active' => 1,
            'alias_id' => $existingTeacher->id
        ]);

        $teacher->classes()->attach($request->input('class_id'));

        $teacher->stages()->attach($request->input('stage_ids'));
        return redirect()->route('teachers.addSchool', ['teacherId' => $request->mainteacher])
        ->with('success', 'School added to teacher successfully.');
    
    }
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:teachers',
            'gender' => 'required',
            'school_id' => 'required|exists:schools,id',
            'stage_ids' => 'required|array',
            'stage_ids.*' => 'exists:stages,id',
            'class_id' => 'required|array',
            'class_id.*' => 'exists:groups,id',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $username = str_replace(' ', '_', $request->input('username'));

        $password = Str::random(8);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('teachers', 'public');
        }

        $teacher = Teacher::create([
            'username' => $username,
            'password' => Hash::make($password),
            'plain_password' => $password,
            'gender' => $request->input('gender'),
            'school_id' => $request->input('school_id'),
            'is_active' => 1,
            'image' => $imagePath,
        ]);

        $teacher->classes()->attach($request->input('class_id'));

        $teacher->stages()->attach($request->input('stage_ids'));

        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');
    }
    public function generate(Request $request)
    {
        $request->validate([
            'number_of_teachers' => 'required|integer|min:1',
            'school_id' => 'required|exists:schools,id',
        ]);

        $numberOfTeachers = $request->input('number_of_teachers');
        $schoolId = $request->input('school_id');
        $school = School::findOrFail($schoolId);

        $currentCount = Teacher::where('school_id', $schoolId)->count();

        for ($i = 1; $i <= $numberOfTeachers; $i++) {
            $username = str_replace(' ', '_', strtolower($school->name)) . '_' . ($currentCount + $i);
            $password = Str::random(8);

            Teacher::create([
                'username' => $username,
                'password' => Hash::make($password),
                'plain_password' => $password,
                'school_id' => $schoolId,
                'is_active' => 1,
            ]);
        }

        return redirect()->route('teachers.index')->with('success', "$numberOfTeachers teachers generated successfully.");
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
    // public function edit(string $id)
    // {
    //     $teacher = Teacher::findOrFail($id);
    //     $schools = School::all();
    //     $stages = Stage::all();

    //     $classes = Group::where('school_id', $teacher->school_id)->get();

    //     return view('admin.teachers.edit', compact('teacher', 'schools', 'classes', 'stages'));
    // }

    public function edit(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        $schools = School::all();

        $stages = Stage::whereHas('schools', function ($query) use ($teacher) {
            $query->where('school_id', $teacher->school_id);
        })->get();

        // Fetch classes related to the teacher's school.
        $classes = Group::where('school_id', $teacher->schools)->get();

        return view('admin.teachers.edit', compact('teacher', 'schools', 'classes', 'stages'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $teacher = Teacher::findOrFail($id);

        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'stage_ids' => 'required|array',
            'stage_ids.*' => 'exists:stages,id',
            'class_id' => 'required|array',
            'class_id.*' => 'exists:groups,id',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $username = str_replace(' ', '_', $request->input('username'));

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('teachers', 'public');
            $teacher->image = $imagePath;
        }

        $teacher->update([
            'school_id' => $request->input('school_id'),
            'is_active' => $request->input('is_active') ?? 1,
        ]);

        $teacher->classes()->sync($request->input('class_id'));
        $teacher->stages()->sync($request->input('stage_ids'));

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        if($id != $request->mainteacher){
            $teacher = Teacher::findOrFail($id);
            // $teacher->delete();
        }else{
            if(!empty(json_decode($request->teacher_aliases))){
                dd($request->all());
                foreach(json_decode($request->teacher_aliases) as $teacherAlias){
                    // dd($teacherAlias);
                    $teacher = Teacher::find($teacherAlias->id);
                    $teacher->update([
                        'alias_id' => null,
                    ]);
                    dd('done');
                }
            }else{
                dd("Empty");
            }
        }

        if($request->school_list_flag == 1){
            return redirect()->route('teachers.addSchool', ['teacherId' => $request->mainteacher])
            ->with('success', 'School removed from this teacher successfully.');
        }
        
      
      
    }
}
