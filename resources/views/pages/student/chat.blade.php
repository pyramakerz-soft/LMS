@extends('layouts.app')
@section('title')
    Chat
@endsection
@php
    if (auth()->guard('student')->check()) {
        $menuItems = [
            ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('student.theme')],
            ['label' => 'Assignment', 'icon' => 'fas fa-home', 'route' => route('student.assignment')],
            ['label' => 'Chat', 'icon' => 'fa-solid fa-message', 'route' => route('chat.all')],
        ];
    } elseif (auth()->guard('teacher')->check()) {
        $menuItems = [
            ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')],
            ['label' => 'Resources', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.resources.index')],
            ['label' => 'Chat', 'icon' => 'fa-solid fa-message', 'route' => route('chat.all')],
        ];
    } else {
        $menuItems = [];
    }
@endphp
@section('page_css')
    <style>
        /* Header styles */
        .bg-gray-800 {
            @apply bg-gray-800;
        }

        .text-white {
            @apply text-white;
        }

        .p-4 {
            @apply p-4;
        }

        .text-xl {
            @apply text-xl;
        }

        /* Sidebar styles */
        .w-1/4 {
            @apply w-1/4;
        }

        .bg-gray-200 {
            @apply bg-gray-200;
        }

        .overflow-y-auto {
            @apply overflow-y-auto;
        }

        .text-lg {
            @apply text-lg;
        }

        .font-semibold {
            @apply font-semibold;
        }

        .mb-4 {
            @apply mb-4;
        }

        .bg-white {
            @apply bg-white;
        }

        .p-2 {
            @apply p-2;
        }

        .rounded {
            @apply rounded;
        }

        .shadow {
            @apply shadow;
        }

        .hover\:bg-gray-300:hover {
            @apply hover:bg-gray-300;
        }

        /* Chat area styles */
        .flex {
            @apply flex;
        }

        .flex-col {
            @apply flex-col;
        }

        .flex-1 {
            @apply flex-1;
        }

        .overflow-y-auto {
            @apply overflow-y-auto;
        }

        .bg-gray-100 {
            @apply bg-gray-100;
        }

        .text-right {
            @apply text-right;
        }

        .text-left {
            @apply text-left;
        }

        .bg-blue-500 {
            @apply bg-blue-500;
        }

        .text-white {
            @apply text-white;
        }

        .inline-block {
            @apply inline-block;
        }

        /* Footer form styles */
        .border {
            @apply border;
        }

        .ml-2 {
            @apply ml-2;
        }

        .bg-blue-500 {
            @apply bg-blue-500;
        }

        .text-white {
            @apply text-white;
        }

        .px-4 {
            @apply px-4;
        }

        .py-2 {
            @apply py-2;
        }
    </style>
@endsection

@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection
@section('content')
    <div class="flex flex-col h-screen">
        <!-- Header -->
        <header class="bg-gray-800 text-white p-4">
            <h1 class="text-xl">Chat</h1>
        </header>

        <div class="flex flex-1">
            <!-- Left Sidebar -->
            <div class="w-1/4 bg-gray-200 p-4 overflow-y-auto" style="max-height: 700px;">
                <h2 class="text-lg font-semibold mb-4">Contacts</h2>
                @if (auth()->guard('teacher')->check())
                    <!-- List students for the teacher -->
                    <ul>
                        @foreach ($students as $student)
                            <li class="mb-2">
                                <a href="{{ route('chat.form', ['receiverId' => $student->id, 'receiverType' => 'student']) }}"
                                    class="block bg-white p-2 rounded shadow hover:bg-gray-300">
                                    {{ $student->username }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @elseif (auth()->guard('student')->check())
                    <!-- List teachers for the student -->
                    <ul>
                        @foreach ($teachers as $teacher)
                            <li class="mb-2">
                                <a href="{{ route('chat.form', ['receiverId' => $teacher->id, 'receiverType' => 'teacher']) }}"
                                    class="block bg-white p-2 rounded shadow hover:bg-gray-300">
                                    {{ $teacher->username }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Chat Area -->
            <div class="flex-1 flex flex-col">
                <div id="chatArea" class="flex-1 overflow-y-auto p-4 bg-gray-100" style="max-height: 700px;"
                    data-auth-id="{{ auth()->guard('student')->check() ? auth()->guard('student')->id() : auth()->guard('teacher')->id() }}"
                    data-auth-type="{{ auth()->guard('student')->check() ? 'student' : 'teacher' }}">
                    @foreach ($messages as $message)
                        @if (
                            $message->sender_id ==
                                (auth()->guard('student')->check() ? auth()->guard('student')->id() : auth()->guard('teacher')->id()) &&
                                $message->sender_type == (auth()->guard('student')->check() ? 'student' : 'teacher'))
                            <div class="text-right">
                                <div class="bg-blue-500 text-white rounded p-2 mb-2 inline-block">
                                    {{ $message->message }}
                                </div>
                            </div>
                        @else
                            <div class="text-left">
                                <div class="bg-gray-200 rounded p-2 mb-2 inline-block">
                                    {{ $message->message }}
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Input -->
                <footer class="p-4 bg-white border-t">
                    <form id="chatForm" class="flex">
                        <input type="text" id="messageInput" class="flex-1 border rounded p-2"
                            placeholder="Type your message...">
                        <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded">Send</button>
                    </form>
                </footer>
            </div>
        </div>
    </div>
@endsection

@section('page_js')
@endsection
