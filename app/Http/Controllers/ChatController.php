<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\Student;
use App\Models\TeacherClass;
use Auth;
use Illuminate\Http\Request;
use Pusher\Pusher;

class ChatController extends Controller
{
    public function index()
    {
        $teacher = Auth::guard('teacher')->user();

        if (!$teacher) {
            abort(403, 'Unauthorized');
        }

        $classes = $teacher->classes()->with('students')->get();
        return view('pages.teacher.chat', compact('classes'));
    }

    public function studentIndex()
    {
        $student = Auth::guard('student')->user()->id;
        $messages = Message::where('student_id', $student)
            ->orWhereNull('student_id') // For class-wide messages
            ->get();
        // dd($student);

        return view('pages.student.chat', compact('messages'));
    }

    public function sendMessage(Request $request)
    {
        try {
            $teacherId = auth('teacher')->id();

            if (!$teacherId) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $validatedData = $request->validate([
                'student_id' => 'required|exists:students,id',
                'message' => 'required|string|max:255',
            ]);

            $message = Message::create([
                'teacher_id' => $teacherId,
                'student_id' => $validatedData['student_id'],
                'message' => $validatedData['message'],
            ]);

            // Broadcast the message
            broadcast(new MessageSent($message))->toOthers();

            return response()->json($message, 201);
        } catch (\Exception $e) {
            \Log::error('Error sending message', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Server Error'], 500);
        }
    }

    public function fetchMessages($studentId)
    {
        try {
            $teacherId = auth('teacher')->id();

            if (!$teacherId) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $messages = Message::where('teacher_id', $teacherId)
                ->where('student_id', $studentId)
                ->orderBy('created_at', 'asc')
                ->get();

            return response()->json($messages);
        } catch (\Exception $e) {
            \Log::error('Error fetching messages', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Server Error'], 500);
        }
    }


}
