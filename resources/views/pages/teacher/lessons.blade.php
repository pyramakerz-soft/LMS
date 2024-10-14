@extends('layouts.app')

@section('title')
    Lessons for {{ $chapter->title }}
@endsection

@php
    $menuItems = [['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')]];
@endphp

@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection

@section('content')
    <div class="p-3">
        <div class="rounded-lg flex items-center justify-between py-3 px-6 bg-[#2E3646]">
            <div class="flex items-center space-x-4">
                <div>
                    <img class="w-20 h-20 rounded-full" alt="avatar" src="{{ Auth::guard('teacher')->user()->image ? Auth::guard('teacher')->user()->image  : asset('images/default_user.jpg') }}" />
                </div>

                <div class="ml-3 font-semibold text-white flex flex-col space-y-2">
                    <div class="text-xl">
                        {{ Auth::guard('teacher')->user()->username }}
                    </div>
                    <div class="text-sm">
                        {{ Auth::guard('teacher')->user()->school->name }}
                    </div>
                </div>
            </div>
        </div>
        @yield('insideContent')
    </div>

    <div class="p-3 text-[#667085] my-8">
        <i class="fa-solid fa-house mx-2"></i>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="{{ route('teacher.dashboard') }}" class="mx-2 cursor-pointer">Grade</a>
        {{-- <span class="mx-2 text-[#D0D5DD]">/</span>
         <a href="{{ route('') }}" class="mx-2 cursor-pointer">Info</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="{{ url()->previous() }}" class="mx-2 cursor-pointer">Theme</a> --}}
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="{{ route('student_units.index', $chapter->unit_id) }}" class="mx-2 cursor-pointer">Units</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="#" class="mx-2 cursor-pointer">Lessons</a>
    </div>

    {{-- @dd($chapter) --}}
    <!-- Display Lessons -->
    <div class="flex flex-wrap">
        @foreach ($chapter->lessons as $lesson)
            <div class="w-full sm:w-1/2 lg:w-1/4 p-3">
                <div class=" bg-white ">

                    <!-- Lesson Image -->
                    <div class="p-4">
                        <button onclick="event.stopPropagation(); event.preventDefault(); openModal('ebook');"
                            class="object-cover w-full  ">
                            <img src="{{ $lesson->image ? asset($lesson->image) : asset('images/defaultCard.webp') }}" alt="{{ $lesson->title }}">
                        </button>
                    </div>
                    <h3 class="px-4 py-2 text-lg font-bold truncate">{{ $lesson->title }}</h3>
                </div>
            </div>
        @endforeach

    </div>
@endsection



{{-- ------------------------------------------------------------------------------------- --}}

{{-- Ebook Modal --}}
<div id="ebook" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-10 hidden">
    <div class="bg-white rounded-lg shadow-lg h-[95vh] overflow-y-scroll w-[90%]">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">
                EBook
            </h3>
            <div class="flex justify-end">
                <button onclick="closeModal('ebook')"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
            </div>
        </div>
        
        <div class="relative">
            <embed src="{{ $lesson->file_path }}" width="100%" height="90%" />
            <img src="{{  asset('assets/img/watermark 2.png') }}" class="absolute inset-0 w-full h-full pointer-events-none opacity-50">
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove("hidden");
    }

    function closeModal(id) {
        document.getElementById(id).classList.add("hidden");
    }
</script>
