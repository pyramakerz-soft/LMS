@extends('layouts.app')

@section('title')
    Units for {{ $material->title }}
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
        </div>
        @yield('insideContent')
    </div>

    <div class="p-2 text-[#667085] my-8">
        <i class="fa-solid fa-house mx-2"></i>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="{{ route('teacher.dashboard') }}" class="mx-2 cursor-pointer">Grade</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="{{route('teacher.info', $material->stage_id) }}" class="mx-2 cursor-pointer">Info</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="{{ route('teacher.showMaterials' ,$material->stage_id) }}" class="mx-2 cursor-pointer">Theme</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="" class="mx-2 cursor-pointer">Units</a>
    </div>

    <!-- Display Units -->
    {{-- <div class="flex flex-wrap">
        @foreach ($material->units as $unit)
            <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
                <!-- Make the card a clickable link -->
                <a href="{{ route('teacher.chapters.index', $unit->id) }}" class="block">
                    <div class="h-[350px] bg-white shadow-md border border-slate-200 rounded-md">
                        <h3 class="px-4 py-2 bg-gray-200 text-lg font-bold">{{ $unit->title }}</h3>

                        <!-- Unit Image -->
                        <div class="p-4">
                            <img src="{{ $unit->image ? asset($unit->image) : asset('images/default-unit.png') }}"
                                alt="{{ $unit->title }}" class="object-cover w-full h-32 rounded-md">
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div> --}}




    {{-- @dd($material) --}}


    <div class="flex flex-wrap">
        <div id="accordion-collapse " class="w-full p-3">
            <div class="mb-5 ">
                @foreach ($material->units as $unit)
                <div class="m-3">
                    <h2 id="accordion-collapse-heading-{{ $unit->id }}">
                        <button type="button"
                            class="accordion-button flex items-center justify-between w-full p-8 font-medium rtl:text-right text-gray-500 border border-gray-200 dark:border-gray-700 dark:text-gray-400 hover:bg-[#2E3646] rounded-md gap-3 "
                            data-accordion-target="#accordion-collapse-body-{{ $unit->id }}" aria-expanded="false"
                            aria-controls="accordion-collapse-body-{{ $unit->id }}">
                            <span> {{ $unit->title }}</span>
                            <svg data-accordion-icon class="w-3 h-3 shrink-0" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5 5 1 1 5" />
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-collapse-body-{{ $unit->id }}" class="hidden"
                        aria-labelledby="accordion-collapse-heading-{{ $unit->id }}">
                        <div class="p-3 flex flex-wrap justify-start">
                            @foreach ($unit->chapters as $chapter)
                                <div class="mb-7 w-full md:w-[45%] lg:w-[30%] p-2 mx-2 bg-white shadow-md rounded-xl">
                                    <div class="full">
                                        <a class="cursor-pointer h-full flex flex-col justify-between" href="{{ route('teacher.lessons.index', $chapter->id) }}">
                                            <div class="overflow-hidden">
                                                @if ($chapter->image)
                                                    <img src="{{ asset($chapter->image) }}"
                                                        class="object-contain w-full rounded-xl" alt="{{ $chapter->name }}">
                                                @else
                                                    <img src="https://via.placeholder.com/150"
                                                        class="object-contain w-full h-[250px] rounded-xl" alt="No Image">
                                                @endif
                                            </div>
                                            <div class="p-2">
                                                <p class="text-slate-800 text-2xl font-semibold">
                                                    {{ $chapter->title }}
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

        </div>

        <script>
            document.querySelectorAll('.accordion-button').forEach(button => {
                button.addEventListener('click', () => {
                    const accordionBody = document.querySelector(button.getAttribute('data-accordion-target'));
                    const icon = button.querySelector('svg');

                    if (accordionBody.classList.contains('hidden')) {
                        accordionBody.classList.remove('hidden'); // Show accordion content
                        icon.classList.add('rotate-180'); // Rotate icon
                    } else {
                        accordionBody.classList.add('hidden'); // Hide accordion content
                        icon.classList.remove('rotate-180'); // Reset icon rotation
                    }
                });
            });
        </script>
@endsection

{{-- {{ asset($chapter->image) }} --}}