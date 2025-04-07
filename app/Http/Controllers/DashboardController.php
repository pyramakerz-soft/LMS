<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userAuth = auth()->guard('student')->user();

        if ($userAuth) {
            $materials = Material::whereHas('schools', function ($query) use ($userAuth) {
                $query->where('id', $userAuth->school_id);
            })->where('stage_id', $userAuth->stage_id)->get();
            return view('pages.student.theme.index', compact('materials', 'userAuth'));
        } else {
            // If the user is not logged in, redirect to login
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }
    }
}
