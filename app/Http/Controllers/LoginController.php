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
        if ($student && Hash::check($request->input('password'), $student->password)) {
            Auth::guard('student')->login($student); // Log in the student

            // Redirect to student's dashboard or theme page
            return redirect()->route('student.dashboard');
        }

        // Attempt to authenticate as a teacher
        $teacher = Teacher::where('username', $request->input('username'))->first();
        if ($teacher && Hash::check($request->input('password'), $teacher->password)) {
            Auth::guard('teacher')->login($teacher); // Log in the teacher
            return redirect()->route('teacher.dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials are incorrect.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();
        return redirect()->route('login'); 
    }
}
