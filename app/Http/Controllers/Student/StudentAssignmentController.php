<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use Carbon\Carbon;

class StudentAssignmentController extends Controller
{
    public function index()
    {
        $userAuth = auth()->guard('student')->user();

        if ($userAuth) {
            $assignments = $userAuth->assignments()->with('students')->get();
            return view('pages.student.assignment.index', compact('assignments', 'userAuth'));
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }
    }

    public function show($assignmentId){
        $userAuth = auth()->guard('student')->user();

        if ($userAuth) {
            $assignment = Assignment::find($assignmentId);
            if (file_exists($assignment->path_file)) {
                $assignment->file_size = filesize($assignment->path_file);
            } else {
                $assignment->file_size = 'File not found';
            }
            return view('pages.student.assignment.show', compact('assignment', 'userAuth'));
        }
        else {
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }
    }

    public function store(Request $request){
        $userAuth = auth()->guard('student')->user();

        if ($userAuth) {
            $request->validate([
                'file_upload' => 'required|file|mimes:xlsx,xls',
                'assignment_id' => 'required|exists:assignments,id',
            ]);

            $currentTime = Carbon::now();
            
            // $filePath = $request->file('path_file')->store('assignments', 'public');
    
            $studentAssignment = $userAuth->assignments()->with('students')->first();
            $studentAssignment->update([
                // 'assignment_id' => $request->assignment_id,
                // 'student_id' => $userAuth->id,
                'submitted_at' => $currentTime->toDateString(),
                'path_file' => $request->path_file,
            ]);

            return redirect()->route('student.assignment.show', $request->assignment_id)->with('success', 'Assignment submitted successfully.');
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }
    }
}