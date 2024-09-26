@extends('layouts.app')

@section('title')
    @yield('title')
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
    <div class="p-3">
        <div class="rounded-lg flex items-center justify-between py-3 px-6 bg-[#2E3646]">
            <div class="flex items-center space-x-4">
                <div>
                    {{-- <img class="w-20 h-20 rounded-full" alt="avatar1" src="{{ Auth::guard('student')->user()->image }}" /> --}}
                    @if ($userAuth->image)
                        <img src="{{ asset('storage/' . $userAuth->image) }}" alt="Student Image"
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

            <div class="relative">
                <i class="fa-solid fa-bell text-[#FF7519] text-xl"></i>
                <span
                    class="absolute -top-2 -right-2 bg-black border-2 border-white text-white rounded-full text-[10px] px-1 py-0.25">5</span>
            </div>
        </div>
        @yield('insideContent')
    </div>
    <div class="p-3 text-[#667085] my-8">
        <i class="fa-solid fa-house mx-2"></i>
        {{-- @foreach ($paths as $item) --}}
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="#" class="mx-2 cursor-pointer">Theme</a>
        {{-- @endforeach --}}
    </div>
    <div class="p-3 flex flex-wrap justify-start">
        @foreach ($materials as $material)
            <div class="mb-7 w-full md:w-[45%] lg:w-[30%] p-2 mx-2 bg-white shadow-md rounded-xl min-h-[380px]">
                <div class="h-full">
                    <a class="cursor-pointer h-full flex flex-col justify-between"
                        href="{{ route('student_units.index', $material->id) }}">
                        @if ($material->image)
                            <img src="{{ asset('storage/' . $material->image) }}" alt="{{ $material->title }}"
                                class="object-contain w-full h-[250px] rounded-xl">
                        @else
                            No Image
                        @endif
                        <div class="text-slate-800">
                            <div class="flex justify-between items-center text-2xl">
                                <p class="font-semibold">{{ $material->title }}</p>
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
            {{-- Ebook Modal --}}
            <div id="ebook" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
                <div class="bg-white rounded-lg shadow-lg w-1/3">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">
                            EBook
                        </h3>
                    </div>
                    {{-- Put the EBook Here --}}
                    {{ $material->file_path }}
                    <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                        <button onclick="closeModal('ebook')"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">Close</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

{{-- ------------------------------------------------------------------------------------- --}}



{{-- How To Use Modal --}}
<div id="use" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-1/3">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">
                How To Use
            </h3>
        </div>
        {{-- Put the How To Use Here --}}
        <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
            <button onclick="closeModal('use')"
                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">Close</button>
        </div>
    </div>
</div>

{{-- Learning Modal --}}
<div id="learn" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-1/3">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">
                Learning
            </h3>
        </div>
        {{-- Put the Learning Here --}}
        <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
            <button onclick="closeModal('learn')"
                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">Close</button>
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
