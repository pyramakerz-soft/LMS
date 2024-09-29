<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;

class StudentAssignmentController extends Controller
{
    public function index()
    {
        $userAuth = auth()->guard('student')->user();

        if ($userAuth) {
            $assignments = Material::where('stage_id', $userAuth->stage_id)->get();
            return view('pages.student.assignment.index', compact('assignments', 'userAuth'));
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }
    }
}
