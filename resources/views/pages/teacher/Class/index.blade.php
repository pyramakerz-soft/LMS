@extends('layouts.app')

@section('title')
    Classes
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
        </div>
        @yield('insideContent')
    </div>

    <div class="p-3 text-[#667085] my-8">
        <i class="fa-solid fa-house mx-2"></i>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="#" class="mx-2 cursor-pointer">Classes</a>
    </div>

    <!-- Display Chapters -->
    <div class="flex flex-wrap ">
        @if (count($classesTeachers) == 0)
            <div>
                No Classes Assigned to this user
            </div>
        @endif
        {{-- @foreach ($classesTeachers as $classesTeacher)
            <div class="w-full sm:w-1/2 lg:w-1/4 p-3">
                <a href="{{ route('assessments.index', ['class_id' => $classesTeacher->class->id]) }}" class=" bg-white ">

                    <div class="p-4">
                        <img src="{{ $classesTeacher->class->image ? asset($classesTeacher->class->image) : asset('images/default-material.png') }}"
                            alt="{{ $classesTeacher->class->name }}" class="object-cover w-full  rounded-md">
                    </div>
                    <h3 class="px-4 py-2 text-lg font-bold">{{ $classesTeacher->class->name }}</h3>
                </a>
            </div>
        @endforeach --}}
        @foreach ($classesTeachers as $classesTeacher)
            <div class="w-full sm:w-1/2 lg:w-1/4 p-3">
                <a href="{{ route('students_classess', ['class_id' => $classesTeacher->class->id]) }}" class="bg-white">
                    <!-- Chapter Image -->
                    <div class="p-4">
                        <img src="{{ $classesTeacher->class->image ? asset($classesTeacher->class->image) : asset('images/default-material.png') }}"
                            alt="{{ $classesTeacher->class->name }}" class="object-cover w-full rounded-md">
                    </div>
                    <h3 class="px-4 py-2 text-lg font-bold">{{ $classesTeacher->class->name }}</h3>
                </a>
            </div>
        @endforeach
    </div>
@endsection
