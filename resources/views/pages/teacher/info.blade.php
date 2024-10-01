@extends('layouts.app')

@section('title')
    Teacher Dashboard
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
                    {{-- <img class="w-20 h-20 rounded-full" alt="avatar" src="{{ Auth::guard('teacher')->user()->image }}" /> --}}
                    @if (Auth::guard('teacher')->user()->image)
                        <img src="{{ asset(Auth::guard('teacher')->user()->image) }}" alt="Teacher Image"
                            class="w-20 h-20 rounded-full">
                    @else
                        <img src="{{ asset('storage/students/profile-png.webp') }}" alt="Student Image"
                            class="w-30 h-20 rounded-full">
                    @endif
                </div>

                <div class="ml-3 font-semibold text-white flex flex-col space-y-2">
                    <div class="text-xl">
                        {{ Auth::guard('teacher')->user()->username }}
                    </div>
                    <div class="text-sm">
                        <!-- Optionally show the teacher's school -->
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
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="" class="mx-2 cursor-pointer">Info</a>
    </div>

    <!-- Display Stages -->
    <div class="flex flex-wrap p-5">
            <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
                <div class=" bg-white  ">
                    <!-- Make the stage card a link -->
                    <a href="{{ route('teacher.showMaterials' ,$id) }}" class="block h-full">
                        
                        <!-- Stage Image -->
                        <div class="p-4">
                            <img src="{{ asset('assets/img/teacherInfo1.png') }}"
                            alt="" class="object-cover w-full h-45 rounded-md">
                        </div>

                        <h3 class="px-4 py-2 text-lg font-bold">Materials</h3>
                    </a>
                </div>
            </div>
            <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
                <div class=" bg-white  ">
                    <!-- Make the stage card a link -->
                    <a href="{{route('assignments.index')}}" class="block h-full">
                        
                        <!-- Stage Image -->
                        <div class="p-4">
                            <img src="{{ asset('assets/img/teacherInfo2.png') }}"
                            alt="" class="object-cover w-full h-45 rounded-md">
                        </div>
                        <h3 class="px-4 py-2 text-lg font-bold">Assignments</h3>
                    </a>
                </div>
            </div>
            <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
                <div class=" bg-white  ">
                    <!-- Make the stage card a link -->
                    <a href="{{route('assessments.index')}}" class="block h-full">
                        
                        <!-- Stage Image -->
                        <div class="p-4">
                            <img src="{{ asset('assets/img/teacherInfo3.png') }}"
                            alt="" class="object-cover w-full h-45 rounded-md">
                        </div>
                        <h3 class="px-4 py-2 text-lg font-bold">Assessments</h3>
                    </a>
                </div>
            </div>
    </div>
@endsection
