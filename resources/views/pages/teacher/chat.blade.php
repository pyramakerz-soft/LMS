@extends('layouts.app')

@section('title', 'Chat')

@section('sidebar')
    @include('components.sidebar', [
        'menuItems' => [
            ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')],
            ['label' => 'Chat', 'icon' => 'fas fa-comments', 'route' => route('teacher.chat')],
        ],
    ])
@endsection

@section('content')
    <div class="p-4">
        <h1 class="text-2xl font-bold">Chat</h1>

        <div class="grid grid-cols-4 gap-4">
            @if (auth('teacher')->check())
                @foreach (auth('teacher')->user()->classes as $class)
                    <div class="bg-white p-4 rounded shadow">
                        <h2 class="text-lg font-bold">{{ $class->name }}</h2>
                        <ul>
                            @foreach ($class->students as $student)
                                <li class="my-2 flex items-center justify-between">
                                    <span>{{ $student->username }}</span>
                                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600"
                                        onclick="startChat({{ $student->id }}, '{{ $student->username }}')">
                                        Chat
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            @else
                <p>You are not logged in as a teacher.</p>
            @endif
        </div>

        <div id="chat-box" class="mt-8 hidden">
            <h2 id="chat-title" class="text-xl font-bold"></h2>
            <div id="messages" class="border p-4 h-64 overflow-y-auto bg-gray-50"></div>
            <input id="message-input" type="text" class="w-full mt-2 p-2 border rounded" placeholder="Type a message">
            <button class="mt-2 px-4 py-2 bg-blue-500 text-white rounded" onclick="sendMessage()">Send</button>
        </div>
    </div>


@endsection
@section('page_js')

    <script>
        let selectedStudentId = null;

        function startChat(studentId, studentName) {
            selectedStudentId = studentId; // Store the selected student's ID
            document.getElementById('chat-title').textContent = `Chat with ${studentName}`;
            document.getElementById('chat-box').classList.remove('hidden');
            document.getElementById('messages').innerHTML = ''; // Clear previous messages
            fetchMessages(studentId); // Fetch previous messages for this student
        }

        function sendMessage() {
    const message = document.getElementById('message-input').value;

    if (!selectedStudentId || !message.trim()) {
        alert('Please select a student and type a message.');
        return;
    }

    fetch('{{ route('teacher.chat.send') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({
            student_id: selectedStudentId,
            message,
        }),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const messages = document.getElementById('messages');
            messages.innerHTML += `<div><strong>You:</strong> ${data.message}</div>`;
            messages.scrollTop = messages.scrollHeight;
            document.getElementById('message-input').value = ''; // Clear the input field
        })
        .catch(error => {
            console.error('Error sending message:', error);
            alert('Failed to send message. Please try again.');
        });
}


        function fetchMessages(studentId) {
    fetch(`/teacher/chat/messages/${studentId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(messages => {
            if (!Array.isArray(messages)) {
                throw new Error('Invalid response format');
            }
            const messagesContainer = document.getElementById('messages');
            messages.forEach(message => {
                const sender = message.sender === 'teacher' ? 'You' : 'Student';
                messagesContainer.innerHTML +=
                    `<div><strong>${sender}:</strong> ${message.message}</div>`;
            });
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        })
        .catch(error => {
            console.error('Error fetching messages:', error);
            alert('Failed to fetch messages. Please try again.');
        });
}

    </script>
@endsection
