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
    public function viewAllChats(Request $request)
    {
        $students = collect();
        $teachers = collect();
        $classes = collect();
        $perPage = 10; // Number of results per page

        if (auth()->guard('teacher')->check()) {
            $userId = auth()->guard('teacher')->user()->id;

            // Get the classes assigned to the teacher
            $classes = TeacherClass::where('teacher_id', $userId)->with('class')->get();

            // Filter and sort students
            $classId = $request->query('class_id');
            $search = $request->query('search');
            $sortBy = $request->query('sort_by', 'username'); // Default sort by 'username'
            $sortOrder = $request->query('sort_order', 'asc'); // Default order 'asc'

            $studentsQuery = Student::query();

            if ($classId) {
                $studentsQuery->where('class_id', $classId);
            }

            if ($search) {
                $studentsQuery->where('username', 'like', "%$search%");
            }

            $students = $studentsQuery->whereIn('class_id', $classes->pluck('class_id'))
                ->orderBy($sortBy, $sortOrder)
                ->paginate($perPage);
        } elseif (auth()->guard('student')->check()) {
            $userId = auth()->guard('student')->user()->id;

            // Get the student's class
            $student = Student::find($userId);

            if (!$student) {
                abort(404, 'Student not found');
            }

            // Filter and sort teachers
            $teachersQuery = Teacher::query();
            $teachers = $teachersQuery->whereHas('classes', function ($query) use ($student) {
                $query->where('class_id', $student->class_id);
            })
                ->orderBy('username', 'asc') // Default sort for teachers
                ->paginate($perPage);
        } else {
            abort(403, 'Unauthorized access');
        }

        return view('pages.student.all', compact('students', 'teachers', 'classes'));
    }




    public function chatForm($receiverId, $receiverType, UserService $userService)
    {
        $receiver = $userService->getUserById($receiverId, $receiverType);

        if (!$receiver) {
            abort(404, 'Receiver not found');
        }

        $students = collect();
        $teachers = collect();

        if (auth()->guard('student')->check()) {
            $userId = auth()->guard('student')->user()->id;
            $userType = 'student';

            $student = Student::find($userId);
            if (!$student) {
                abort(404, 'Student not found');
            }

            $teachers = Teacher::whereHas('classes', function ($query) use ($student) {
                $query->where('class_id', $student->class_id);
            })->get();
        } elseif (auth()->guard('teacher')->check()) {
            $userId = auth()->guard('teacher')->user()->id;
            $userType = 'teacher';

            $teacherClasses = TeacherClass::where('teacher_id', $userId)->pluck('class_id');
            $students = Student::whereIn('class_id', $teacherClasses)->get();
        } else {
            abort(403, 'Unauthorized access');
        }

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

        // Get the last message ID
        $lastMessageId = $messages->last() ? $messages->last()->id : 0;

        return view('pages.student.chat', compact('receiver', 'receiverType', 'messages', 'students', 'teachers', 'lastMessageId'));
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
            ->where('id', '>', $lastMessageId) // Fetch only messages after last_message_id
            ->orderBy('created_at', 'asc')
            ->get();

        Message::where('receiver_id', $userId)
            ->where('receiver_type', $userType)
            ->where('sender_id', $receiverId)
            ->where('sender_type', $receiverType)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['messages' => $messages]);
    }


}