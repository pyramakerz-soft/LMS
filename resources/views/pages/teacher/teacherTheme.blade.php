@extends('layouts.app')

@section('title')
    Theme
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
                    <img class="w-20 h-20 rounded-full" alt="avatar" src="{{ auth()->user()->image }}" />
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
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="{{route('teacher.info', $stage->id) }}" class="mx-2 cursor-pointer">Info</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="#" class="mx-2 cursor-pointer">Theme</a>

    </div>
    <div class="p-3 flex flex-wrap justify-start">
        {{-- @dd($stage->materials) --}}
        @foreach ($stage->materials as $material)
            <div class="mb-7 w-full md:w-[45%] lg:w-[30%] p-2 mx-2 bg-white shadow-md rounded-xl min-h-[380px]">
                <div class="h-full">
                    <a class="cursor-pointer h-full flex flex-col justify-between"
                        href="{{ route('teacher.units' ,$material->id ) }}">
                        @if ($material->image)
                          
                            <img src="{{ asset($material->image) }}" alt="{{ $material->name }}"
                                class="object-cover object-top w-full h-[350px] rounded-xl">
                        @else
                            No Image
                        @endif
                        <div class="text-slate-800">
                            <div class="flex justify-between items-center text-2xl">
                                <p class="font-semibold">{{ $material->name }}</p>
                                <button class="pt-2"
                                    onclick="event.stopPropagation(); event.preventDefault(); openModal('ebook');">
                                    <img src="{{ asset('images/Clip path group.png') }}">
                                </button>
                            </div>
                            <div class="flex justify-between items-center mt-4">
                                <div>
                                    <button class="bg-[#17253E] p-2 text-white rounded-md"
                                        onclick="event.stopPropagation(); event.preventDefault(); openModal('use');">
                                        How To Use
                                        <button>
                                </div>
                                <div>
                                    <button class="bg-white border border-[#FF7519] p-2 text-black font-semibold rounded-md"
                                        onclick="event.stopPropagation(); event.preventDefault(); openModal('learn');">
                                        Learning Outcomes
                                        <button>
                                </div>
                            </div>
                        </div>
                    </a>
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
        <embed src="{{ $material->file_path }}" width="100%" height="90%" />

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
        <embed src="{{ $material->how_to_use }}" width="800px" height="2100px" />
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
        <embed src="{{ $material->learning }}" width="800px" height="2100px" />
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
