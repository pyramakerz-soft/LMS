<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;

class StudentAssignmentController extends Controller
{
    public function index()
    {
        $userAuth = auth()->guard('student')->user();

        if ($userAuth) {
            // $assignments = Assignment::where('stage_id', $userAuth->stage_id)->get();
            $assignments = Assignment::all();
            @dd($assignments);
            return view('pages.student.assignment.index', compact('assignments', 'userAuth'));
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }
    }
}
