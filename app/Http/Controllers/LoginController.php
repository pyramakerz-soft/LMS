<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle the login logic for both students and teachers
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Attempt to authenticate as a student
        $student = Student::where('username', $request->input('username'))->first();

        if ($student) {
            if (Hash::check($request->input('password'), $student->password)) {
                Auth::guard('student')->login($student); // Log in the student
                return redirect()->route('student.dashboard');
            } else {
                // Password is incorrect
                return back()->withErrors([
                    'password' => 'The provided Password is incorrect.',
                ]);
            }
        }

        // Attempt to authenticate as a teacher
        $teacher = Teacher::where('username', $request->input('username'))->first();
        if ($teacher) {
            if (Hash::check($request->input('password'), $teacher->password)) {
                Auth::guard('teacher')->login($teacher); // Log in the teacher
                return redirect()->route('teacher.dashboard');
            } else {
                // Password is incorrect
                return back()->withErrors([
                    'password' => 'The provided Password is incorrect.',
                ]);
            }
        }

        return back()->withErrors([
            'username' => 'The provided Username is incorrect.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();
        return redirect()->route('login'); 
    }
}
