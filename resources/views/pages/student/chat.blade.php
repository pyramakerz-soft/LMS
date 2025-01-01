@extends('layouts.app')

@section('title', 'Chat')

@section('sidebar')
    @include('components.sidebar', [
        'menuItems' => [
            ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('student.theme')],
            ['label' => 'Chat', 'icon' => 'fas fa-comments', 'route' => route('student.chat')],
        ],
    ])
@endsection

@section('content')
    <div class="p-4">
        <h1 class="text-2xl font-bold">Chat</h1>

        <div id="messages" class="border p-4 h-64 overflow-y-auto bg-gray-50">
            @foreach ($messages as $message)
                <div>{{ $message->message }}</div>
            @endforeach
        </div>
    </div>
@endsection

@section('page_js')

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const studentId = {{ auth('student')->id() }};
            const messagesContainer = document.getElementById('messages');

            if (typeof Echo === 'undefined') {
                console.error('Echo is not defined. Ensure Laravel Echo is properly initialized.');
                return;
            }

            // Initialize Laravel Echo and listen for events
            Echo.private(`student-chat.${studentId}`)
                .listen('.message.sent', (event) => {
                    const message = event.message;

                    // Create a new message element
                    const messageElement = document.createElement('div');
                    messageElement.textContent = message.message;
                    messagesContainer.appendChild(messageElement);

                    // Scroll to the bottom of the chat
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                });
        });
    </script>
@endsection
