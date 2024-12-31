<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\Student;
use App\Models\TeacherClass;
use Auth;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $userAuth = Auth::guard('teacher')->check() ? Auth::guard('teacher')->user() : Auth::guard('student')->user();

        if ($userAuth instanceof \App\Models\Teacher) {
            // Fetch the teacher's classes and students
            $teacherClasses = TeacherClass::where('teacher_id', $userAuth->id)->pluck('class_id');
            $students = Student::whereIn('class_id', $teacherClasses)->get();
            return view('chat.index', compact('students'));
        } elseif ($userAuth instanceof \App\Models\Student) {
            // Fetch teacher based on the student's class
            $teacher = TeacherClass::where('class_id', $userAuth->class_id)->first()->teacher ?? null;
            return view('chat.index', compact('teacher'));
        }

        return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
    }

    public function fetchMessages(Request $request)
    {
        $userAuth = Auth::guard('student')->user();

        $messages = Message::where(function ($query) use ($request, $userAuth) {
            $query->where('sender_id', $userAuth->id)
                ->where('sender_type', 'App\Models\Student')
                ->where('receiver_id', $request->receiver_id)
                ->where('receiver_type', 'App\Models\Teacher');
        })->orWhere(function ($query) use ($request, $userAuth) {
            $query->where('sender_id', $request->receiver_id)
                ->where('sender_type', 'App\Models\Teacher')
                ->where('receiver_id', $userAuth->id)
                ->where('receiver_type', 'App\Models\Student');
        })->orderBy('created_at')->get();

        return view('chat.partials.messages', compact('messages'));
    }

    public function sendMessage(Request $request)
    {
        $sender_id = Auth::user()->id;

        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|exists:students,id',
            'receiver_type' => 'required|string|in:App\Models\Teacher,App\Models\Student',
        ]);

        // Create the message
        $message = Message::create([
            'sender_id' => $sender_id,
            'sender_type' => Auth::guard('teacher')->check() ? 'App\Models\Teacher' : 'App\Models\Student',
            'receiver_id' => $request->receiver_id,
            'receiver_type' => $request->receiver_type,
            'message' => $request->message,
        ]);

        // Broadcast the message to Pusher
        broadcast(new MessageSent($message))->toOthers();

        // Redirect back to the chat page with success message
        return redirect()->route('chat.index')->with('success', 'Message sent successfully.');
    }
}
