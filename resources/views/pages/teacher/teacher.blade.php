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
        </div>
        @yield('insideContent')
    </div>

    <div class="p-2 text-[#667085] my-8">
        <i class="fa-solid fa-house mx-2"></i>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="" class="mx-2 cursor-pointer">Grade</a>
    </div>

    <!-- Display Stages -->
    <div class="flex flex-wrap">
        @foreach ($stages as $stage)
            <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
                <div class=" bg-white ">
                    <!-- Make the stage card a link -->
                    <a href="{{ route('teacher.info', $stage->id) }}" class="block h-full">
                        
                        <!-- Stage Image -->
                        <div class="p-4">

                            <img src="{{ $stage->image ? asset($stage->image) : asset('images/default-stage.png') }}"
                            alt="{{ $stage->name }}" class="object-cover w-full h-45 rounded-md">

                        </div>
                        <h3 class="px-4 py-2 text-lg font-bold">{{ $stage->name }}</h3>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection



