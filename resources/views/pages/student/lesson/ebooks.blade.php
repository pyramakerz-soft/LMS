@extends('layouts.app')

@section('title')
    eBooks for {{ $lesson->title }}
@endsection

@php
    $menuItems = [
        ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('student.theme')],
        ['label' => 'Assignment', 'icon' => 'fas fa-home', 'route' => 'student.assignment'],
    ];
@endphp

@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection

@section('content')
    <div class="p-5">
        <div class="rounded-lg flex items-center justify-between py-3 px-6 bg-[#2E3646]">
            <div class="flex items-center space-x-4">
                <div>
                    @if ($userAuth->image)
                        <img src="{{ asset('storage/' . $userAuth->image) }}" alt="Student Image"
                            class="w-20 h-20 rounded-full">
                    @else
                        <img src="{{ asset('storage/students/profile-png.webp') }}" alt="Student Image"
                            class="w-30 h-20 rounded-full">
                    @endif
                </div>

                <div class="ml-3 font-semibold text-white flex flex-col space-y-2">
                    <div class="text-xl">
                        {{ $userAuth->username }}
                    </div>
                    <div class="text-sm">
                        {{ $userAuth->stage->name }}
                    </div>
                </div>
            </div>

            <div class="relative">
                <i class="fa-solid fa-bell text-[#FF7519] text-xl"></i>
                <span
                    class="absolute -top-2 -right-2 bg-black border-2 border-white text-white rounded-full text-[10px] px-1 py-0.25">5</span>
            </div>
        </div>
        @yield('insideContent')
    </div>

    <div class="p-2 text-[#667085] my-8">
        <i class="fa-solid fa-house mx-2"></i>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="{{ route('student_chapters.index', $lesson->chapter->unit_id) }}" class="mx-2 cursor-pointer">Lessons</a>
    </div>

    <!-- Display eBooks -->
    <div class="flex flex-wrap">
        @foreach ($lesson->ebooks as $ebook)
            <div class="w-full sm:w-1/2 lg:w-1/3 p-2">
                <div class="h-[350px] bg-white shadow-md border border-slate-200 rounded-md">
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-700">{{ $ebook->title }}</h3>
                        <p class="text-gray-600">{{ $ebook->description }}</p>

                        <!-- Lesson Name -->
                        <p class="text-gray-500">Lesson: {{ $lesson->title }}</p>

                        <!-- eBook Download Link -->
                        <a href="{{ asset('storage/' . $ebook->file_path) }}"
                            class="inline-block mt-4 text-blue-500 hover:text-blue-700 font-semibold" target="_blank">View
                            eBook</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
