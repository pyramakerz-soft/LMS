@extends('layouts.app')

@section('title')
    All Chats
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

@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection
@section('page_css')
    <style>
        .chat-card {
            max-height: 700px;
            border-radius: 10px;
            overflow-y: auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .contact-card {
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 8px;
            background-color: #f9f9f9;
            margin-bottom: 8px;
            cursor: pointer;
        }

        .contact-card:hover {
            background-color: #e5e5e5;
        }

        .contact-card img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .message {
            margin-bottom: 15px;
            max-width: 60%;
            padding: 10px;
            border-radius: 10px;
            display: inline-block;
        }

        .message.sent {
            background-color: #007bff;
            color: white;
            align-self: flex-end;
        }

        .message.received {
            background-color: #e5e5e5;
            color: black;
            align-self: flex-start;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a,
        .pagination span {
            margin: 0 5px;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
        }

        .pagination a:hover {
            background-color: #f0f0f0;
        }

        .pagination .active span {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .bg-red-500 {
            background-color: #f56565;
        }

        .bg-red-500:hover {
            background-color: #c53030;
        }
    </style>
@endsection

@section('content')
    <div class="flex flex-col h-screen">
        <header class="bg-gray-800 text-white p-4">
            <h1 class="text-xl">All Chats</h1>
        </header>

        <div class="flex-1 p-4 bg-gray-100">
            @if (auth()->guard('teacher')->check())
                <!-- Filter and Sort Section -->
                <div class="mb-4 flex items-center justify-between">
                    <!-- Filter and Search Form -->
                    <form method="GET" action="{{ route('chat.all') }}" class="flex items-center">
                        <select name="class_id" class="border rounded p-2 mr-2">
                            <option value="">All Classes</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->class->id }}"
                                    {{ request('class_id') == $class->class->id ? 'selected' : '' }}>
                                    {{ $class->class->name }}
                                </option>
                            @endforeach
                        </select>

                        <input type="text" name="search" placeholder="Search by username"
                            class="border rounded p-2 mr-2" value="{{ request('search') }}">

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
                    </form>

                    <!-- Sort Form -->
                    <form method="GET" action="{{ route('chat.all') }}" class="flex items-center">
                        <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <select name="sort_by" class="border rounded p-2 mr-2">
                            <option value="username" {{ request('sort_by') == 'username' ? 'selected' : '' }}>Username
                            </option>
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Created At
                            </option>
                        </select>
                        <select name="sort_order" class="border rounded p-2 mr-2">
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending
                            </option>
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending
                            </option>
                        </select>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Sort</button>
                    </form>

                    <!-- Clear All Filters Button -->
                    <a href="{{ route('chat.all') }}" class="bg-red-500 text-white px-4 py-2 rounded">
                        Clear
                    </a>
                </div>
            @endif

            <!-- Contacts Section -->
            <div>
                <h2 class="text-lg font-semibold mb-4">Contacts</h2>
                <ul>
                    @if (auth()->guard('teacher')->check())
                        <!-- Display students for the teacher -->
                        @foreach ($students as $student)
                            <li class="mb-2">
                                <a href="{{ route('chat.form', ['receiverId' => $student->id, 'receiverType' => 'student']) }}"
                                    class="block bg-white p-2 rounded shadow hover:bg-gray-300">
                                    {{ $student->username }}
                                </a>
                            </li>
                        @endforeach
                    @elseif (auth()->guard('student')->check())
                        <!-- Display teachers for the student -->
                        @foreach ($teachers as $teacher)
                            <li class="mb-2">
                                <a href="{{ route('chat.form', ['receiverId' => $teacher->id, 'receiverType' => 'teacher']) }}"
                                    class="block bg-white p-2 rounded shadow hover:bg-gray-300">
                                    {{ $teacher->username }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                @if (auth()->guard('teacher')->check())
                    {{ $students->appends(request()->query())->links() }}
                @elseif (auth()->guard('student')->check())
                    {{ $teachers->appends(request()->query())->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection
