@extends('layouts.app')

@section('title')
    Lessons for {{ $chapter->title }}
@endsection

@php
    $menuItems = [
        ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')],
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
                    <img class="w-20 h-20 rounded-full" alt="avatar" src="{{ Auth::guard('teacher')->user()->image }}" />
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
        <a href="{{ route('teacher.dashboard') }}" class="mx-2 cursor-pointer">Grade</a>
       {{-- <span class="mx-2 text-[#D0D5DD]">/</span>
         <a href="{{ route('') }}" class="mx-2 cursor-pointer">Info</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="{{ url()->previous() }}" class="mx-2 cursor-pointer">Theme</a> --}}
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="{{ url()->previous() }}" class="mx-2 cursor-pointer">Units</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="#" class="mx-2 cursor-pointer">Lessons</a>
    </div>

    {{-- @dd($chapter) --}}
    <!-- Display Lessons -->
    <div class="flex flex-wrap">
@foreach ($chapter->lessons as $lesson)
<div class="w-full sm:w-1/2 lg:w-1/4 p-2">
    <div class=" bg-white ">
        
        <!-- Lesson Image -->
        <div class="p-4">
            <button  onclick="event.stopPropagation(); event.preventDefault(); openModal('ebook');" class="object-cover w-full  ">
                <img src="{{ $lesson->image ? asset($lesson->image) : asset('images/default-lesson.png') }}"
                {{-- <img src="{{ asset('assets/img/teacherInfo1.png') }}" --}}
                alt="{{ $lesson->title }}" >
            </button>
        </div>
        <h3 class="px-4 py-2 text-lg font-bold">{{ $lesson->title }}</h3>
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
        {{-- Put the EBook Here --}}
        <embed src="{{ $lesson->file_path }}" width="100%" height="90%" />

    </div>
</div>

{{-- How To Use Modal --}}
<div id="use" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden z-10">
    <div class="bg-white rounded-lg shadow-lg h-[95vh] overflow-y-scroll">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">
                How To Use
            </h3>
            <div class="flex justify-end">
                <button onclick="closeModal('use')"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
            </div>
        </div>
        {{-- Put the How To Use Here --}}
        <embed src="{{ asset($lesson->how_to_use . '/Index.html') }}" width="800px" height="2100px" />
    </div>
</div>

{{-- Learning Modal --}}
<div id="learn" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden z-10">
    <div class="bg-white rounded-lg shadow-lg h-[95vh] overflow-y-scroll">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">
                Learning
            </h3>
            <div class="flex justify-end">
                <button onclick="closeModal('learn')"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
            </div>
        </div>
        {{-- Put the Learning Here --}}
        <embed src="{{ asset($lesson->learning . '/Index.html') }}" width="800px" height="2100px" />
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
