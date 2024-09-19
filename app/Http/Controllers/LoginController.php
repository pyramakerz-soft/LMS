<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            return redirect()->route('student.dashboard'); // Redirect to student dashboard
        }

        // Attempt to authenticate as a teacher
        $teacher = Teacher::where('username', $request->input('username'))->first();
        if ($teacher && Hash::check($request->input('password'), $teacher->password)) {
            Auth::guard('teacher')->login($teacher); // Log in the teacher
            return redirect()->route('teacher.dashboard'); // Redirect to teacher dashboard
        }

        // If login fails, return with an error
        return back()->withErrors([
            'username' => 'The provided credentials are incorrect.',
        ]);
    }

    // Handle logout for both students and teachers
    public function logout(Request $request)
    {
        Auth::logout(); // Log out the user
        return redirect()->route('login'); // Redirect to the login page
    }
}
