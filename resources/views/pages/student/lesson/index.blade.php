@extends('layouts.app')

@section('title')
    Lessons for {{ $chapter->title }}
@endsection

@php
    $menuItems = [
        ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('student.theme')],
        ['label' => 'Assignment', 'icon' => 'fas fa-home', 'route' => route('student.assignment')],
    ];
@endphp

@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection

@section('content')
    <div class="p-3">
        <div class="rounded-lg flex items-center justify-between py-3 px-6 bg-[#2E3646]">
            <div class="flex items-center space-x-4">
                <div>
                    @if ($userAuth->image)
                        <img src="{{ asset($userAuth->image) }}" alt="Student Image"
                            class="w-20 h-20 rounded-full object-cover">
                    @else
                        <img src="{{ asset('storage/students/profile-png.webp') }}" alt="Student Image"
                            class="w-30 h-20 rounded-full object-cover">
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
        </div>
        @yield('insideContent')
    </div>

    <div class="p-3 text-[#667085] my-8">
        <i class="fa-solid fa-house mx-2"></i>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="{{ route("student.theme") }}" class="mx-2 cursor-pointer">Theme</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="{{ route("student_units.index", $chapter->unit_id) }}" class="mx-2 cursor-pointer">Unit</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="#" class="mx-2 cursor-pointer">lessons</a>
    </div>

    <div class="flex flex-wrap p-3">
        @foreach ($chapter->lessons as $lesson)
            <div class="mb-7 w-full md:w-[45%] lg:w-[30%] p-2 mx-2 bg-white shadow-md rounded-xl">
                <div class="w-full">
                    <a  onclick="event.stopPropagation(); event.preventDefault(); openModal('ebook');" class="cursor-pointer h-full flex flex-col justify-between">
                        <h3 class="px-4 py-2 bg-gray-200 text-lg font-bold">{{ $lesson->title }}</h3>
                        <div class="p-4">
                            @if ($lesson->image)
                                <img src="{{ asset($lesson->image) }}"
                                    class="object-contain w-full rounded-xl">
                            @else
                                <img src="https://via.placeholder.com/150" class="object-contain w-full h-[250px] rounded-xl"
                                    alt="No Image">
                            @endif
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection



{{----------------------------------------------------------------------------------------------------------------------}}

{{-- Learning Modal --}}
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
        {{-- Put the Learning Here --}}
        <embed src="{{ $lesson->file_path}}" width="100%" height="90%" />
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




