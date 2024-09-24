<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function index($unitId)
    {


        $userAuth = auth()->guard('student')->user();
        if ($userAuth) {
            $unit = Unit::with('chapters')->findOrFail($unitId);
            return view('pages.student.chapter.index', compact('unit' , 'userAuth'));
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }
    }
}
