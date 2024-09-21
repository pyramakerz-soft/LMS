<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index($materialId)
    {
        $userAuth = auth()->guard('student')->user();
        if ($userAuth) {
            $material = Material::with('units')->findOrFail($materialId);
            return view('pages.student.unit.index', data: compact('material', 'userAuth'));
        } else {
            // If the user is not logged in, redirect to login
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }
    }
}
