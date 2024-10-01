@extends('layouts.app')

@section('title')
    Materials for {{ $stage->name }}
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
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="" class="mx-2 cursor-pointer">Materials</a>
    </div>

    <!-- Display Materials -->
    <div class="flex flex-wrap">
        @foreach ($stage->materials as $material)
            <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
                <!-- Wrap the material card in a link to navigate to units -->
                <a href="{{ route('teacher.units', $material->id) }}" class="block">
                    <div class="h-[350px] bg-white shadow-md border border-slate-200 rounded-md">
                        <h3 class="px-4 py-2 bg-gray-200 text-lg font-bold">{{ $material->title }}</h3>

                        <!-- Material Image -->
                        <div class="p-4">
                            <img src="{{ $material->image ? asset($material->image) : asset('images/default-material.png') }}"
                                alt="{{ $material->title }}" class="object-cover w-full h-32 rounded-md">
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection
