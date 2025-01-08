<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\TeacherClass;
use App\Services\UserService;
use Auth;
use Illuminate\Http\Request;
use Pusher\Pusher;

class ChatController extends Controller
{

    public function chatForm($receiverId, $receiverType, UserService $userService)
    {
        $receiver = $userService->getUserById($receiverId, $receiverType);

        if (!$receiver) {
            abort(404, 'Receiver not found');
        }

        $students = collect(); 
        $teachers = collect(); 

        if (auth()->guard('teacher')->check()) {
            $userId = auth()->guard('teacher')->user()->id;
            $userType = 'teacher';

            // Get the classes assigned to the teacher
            $teacherClasses = TeacherClass::where('teacher_id', $userId)->pluck('class_id');

            // Get the students belonging to these classes
            $students = Student::whereIn('class_id', $teacherClasses)->get();
        } elseif (auth()->guard('student')->check()) {
            $userId = auth()->guard('student')->user()->id;
            $userType = 'student';

            // Get the student's class
            $student = Student::find($userId);

            if (!$student) {
                abort(404, 'Student not found');
            }

            // Get the teachers assigned to the student's class
            $teachers = Teacher::whereHas('classes', function ($query) use ($student) {
                $query->where('class_id', $student->class_id);
            })->get();
        } else {
            abort(403, 'Unauthorized access');
        }

        // Fetch messages between the authenticated user and the receiver
        $messages = Message::where(function ($query) use ($userId, $userType, $receiverId, $receiverType) {
            $query->where('sender_id', $userId)
                ->where('sender_type', $userType)
                ->where('receiver_id', $receiverId)
                ->where('receiver_type', $receiverType);
        })
            ->orWhere(function ($query) use ($userId, $userType, $receiverId, $receiverType) {
                $query->where('sender_id', $receiverId)
                    ->where('sender_type', $receiverType)
                    ->where('receiver_id', $userId)
                    ->where('receiver_type', $userType);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Pass variables to the view
        return view('pages.student.chat', compact('receiver', 'receiverType', 'messages', 'students', 'teachers'));
    }





    public function sendMessage($receiverId, $receiverType, Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $senderId = auth()->guard('student')->check() ? auth()->guard('student')->id() : auth()->guard('teacher')->id();
        $senderType = auth()->guard('student')->check() ? 'student' : 'teacher';

        $message = Message::create([
            'sender_id' => $senderId,
            'sender_type' => $senderType,
            'receiver_id' => $receiverId,
            'receiver_type' => $receiverType,
            'message' => $request->message,
        ]);

        return response()->json(['message' => $message], 201);
    }
    public function fetchMessages($receiverId, $receiverType, Request $request)
    {
        $userId = auth()->guard('student')->check() ? auth()->guard('student')->id() : auth()->guard('teacher')->id();
        $userType = auth()->guard('student')->check() ? 'student' : 'teacher';
        $lastMessageId = $request->query('last_message_id', 0);

        $messages = Message::where(function ($query) use ($userId, $userType, $receiverId, $receiverType) {
            $query->where('sender_id', $userId)
                ->where('sender_type', $userType)
                ->where('receiver_id', $receiverId)
                ->where('receiver_type', $receiverType);
        })
            ->orWhere(function ($query) use ($userId, $userType, $receiverId, $receiverType) {
                $query->where('sender_id', $receiverId)
                    ->where('sender_type', $receiverType)
                    ->where('receiver_id', $userId)
                    ->where('receiver_type', $userType);
            })
            ->where('id', '>', $lastMessageId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json(['messages' => $messages]);
    }


}
