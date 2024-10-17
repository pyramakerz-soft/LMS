@extends('layouts.app')

@section('title')
    Theme
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
{{-- @dd(Auth::guard('student')->user()) --}}
    <div class="p-3">
        <div class="rounded-lg flex items-center justify-between py-3 px-6 bg-[#2E3646]">
            <div class="flex items-center space-x-4">
                <div>
                    {{-- <img class="w-20 h-20 rounded-full" alt="avatar1" src="{{ Auth::guard('student')->user()->image }}" /> --}}
                    {{-- @if ($userAuth->image)
                        <img src="{{ asset($userAuth->image) }}" alt="Student Image"
                            class="w-20 h-20 rounded-full object-cover">
                    @else
                        <img src="{{ asset('storage/students/profile-png.webp') }}" alt="Student Image"
                            class="w-30 h-20 rounded-full object-cover">
                    @endif --}}
                    <img  class="w-20 h-20 rounded-full object-cover" alt="avatar" src="{{ $userAuth->image ? asset($userAuth->image)  : asset('images/default_user.jpg') }}" />

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
    </div>
    <div class="p-3 text-[#667085] my-8">
        <i class="fa-solid fa-house mx-2"></i>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="#" class="mx-2 cursor-pointer">Theme</a>
    </div>
    <div class="p-3 flex flex-wrap justify-start">
        @foreach ($materials as $material)
            <div class="mb-7 w-full md:w-[45%] lg:w-[30%] p-2 mx-2 bg-white  rounded-xl min-h-[380px]">
                <div class="h-full">
                    <a class="cursor-pointer h-full flex flex-col justify-between"
                        href="{{ route('student_units.index', $material->id) }}">
                        @if ($material->image)
                            <img src="{{ $material->image }}" alt="{{ $material->title }}"
                                class="object-cover object-top w-full h-[350px] rounded-xl">
                        @else
                            No Image
                        @endif
                        <div class="text-slate-800">
                            <div class="flex justify-between items-center text-2xl ">
                                <!-- Update to handle long titles -->
                                <p class="font-semibold truncate"
                                    style="max-width: 80%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                    {{ $material->title }}
                                </p>
                                <button class="pt-2"
                                    onclick="event.stopPropagation(); event.preventDefault(); openModal('ebook', '{{ $material->file_path }}');">
                                    <img src="{{ asset('images/Clip path group.png') }}">
                                </button>
                            </div>
                            <div class="flex justify-between items-center mt-4">
                                <div>
                                    <button class="bg-[#17253E] p-2 text-white rounded-md"
                                        onclick="event.stopPropagation(); event.preventDefault();openModal('use', '{{ $material->how_to_use }}');">
                                        How To Use
                                    </button>
                                </div>
                                <div>
                                    <button class="bg-white border border-[#FF7519] p-2 text-black font-semibold rounded-md"
                                        onclick="event.stopPropagation(); event.preventDefault(); openModal('learn', '{{ $material->learning }}');">
                                        Learning Outcomes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
        @if(count($materials) == 0)
            <p class="m-auto text-gray-500">No Themes yet</p>
        @endif
    </div>
@endsection

{{-- ------------------------------------------------------------------------------------- --}}

{{-- Ebook Modal --}}
<div id="ebook" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-10 hidden">
    <div class="bg-white rounded-lg shadow-lg h-[95vh] overflow-y-scroll w-[9*
    0%]">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">
                EBook
            </h3>
            <div class="flex justify-end">
                <button onclick="closeModal('ebook')"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
            </div>
        </div>

        <div class="relative" id="ebook-content">
        </div>
    </div>
</div>

{{-- How To Use Modal --}}
<div id="use" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-10 hidden">
    <div class="bg-white rounded-lg shadow-lg h-[95vh] overflow-y-scroll w-[90%]">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">
                How To Use
            </h3>
            <div class="flex justify-end">
                <button onclick="closeModal('use')"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
            </div>
        </div>

        <div class="relative" id="use-content">
        </div>
    </div>
</div>

{{-- Learning Modal --}}
<div id="learn" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-10 hidden">
    <div class="bg-white rounded-lg shadow-lg h-[95vh] overflow-y-scroll w-[90%]">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">
                Learning
            </h3>
            <div class="flex justify-end">
                <button onclick="closeModal('learn')"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
            </div>
        </div>

        <div class="relative" id="learn-content">
        </div>
    </div>
</div>


@section('page_js')
<script>
    function openModal(id, filePath) {
        let modalContent = `
            <embed src="${filePath}" width="100%" height="90%" />
            <img src="{{ asset('assets/img/watermark 2.png') }}" 
                class="absolute inset-0 w-full h-full opacity-50 z-10"
                style="pointer-events: none;">
        `;
        document.getElementById(id + '-content').innerHTML = modalContent;
        document.getElementById(id).classList.remove("hidden");
    }

    function closeModal(id) {
        document.getElementById(id).classList.add("hidden");
    }
</script>
@endsection
