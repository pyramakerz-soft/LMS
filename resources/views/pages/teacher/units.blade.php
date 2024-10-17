@extends('layouts.app')
@section('title')
    Units for {{ $material->title }}
@endsection
@php
    $menuItems = [['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')]];
@endphp
@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection
@section('content')
    @include('components.profile')
    <div class="p-3 text-[#667085] my-8">
        <i class="fa-solid fa-house mx-2"></i>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="{{ route('teacher.dashboard') }}" class="mx-2 cursor-pointer">Grade</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="{{ route('teacher.info', $material->stage_id) }}" class="mx-2 cursor-pointer">Info</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="{{ route('teacher.showMaterials', $material->stage_id) }}" class="mx-2 cursor-pointer">Theme</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="" class="mx-2 cursor-pointer">Units</a>
    </div>
    <div class="flex flex-wrap">
        <div id="accordion-collapse " class="w-full p-3">
            <div class="mb-5 ">
                @foreach ($material->units as $unit)
                    <div class="m-3">
                        <h2 id="accordion-collapse-heading-{{ $unit->id }}">
                            <button type="button"
                                class="accordion-button flex items-center justify-between w-full p-2 font-medium rtl:text-right text-gray-500 dark:text-gray-400 hover:bg-[#2E3646] hover:text-white  rounded-md gap-3"
                                data-accordion-target="#accordion-collapse-body-{{ $unit->id }}" aria-expanded="false"
                                aria-controls="accordion-collapse-body-{{ $unit->id }}">
                                <div class="flex justify-start space-x-2 align-items: center;">
                                    @if ($loop->iteration == 1)
                                        <img src="{{ asset('images/unit1.png') }}"
                                            class="w-[70px] h-[70.21px] rounded-[2.44px]">
                                    @elseif ($loop->iteration == 2)
                                        <img src="{{ asset('images/unit2.png') }}"
                                            class="w-[70px] h-[70.21px] rounded-[2.44px]">
                                    @else
                                        <img src="{{ asset('images/unit3.png') }}"
                                            class="w-[70px] h-[70.21px] rounded-[2.44px]">
                                    @endif
                                    <span class="mt-1 text-2xl"> {{ $unit->title }}</span>
                                </div>
                                <svg data-accordion-icon class="w-3 h-3 shrink-0" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 5 5 1 1 5" />
                                </svg>
                            </button>
                        </h2>
                        <div id="accordion-collapse-body-{{ $unit->id }}" class="hidden"
                            aria-labelledby="accordion-collapse-heading-{{ $unit->id }}">
                            <div class="p-3 flex flex-wrap justify-start">
                                @foreach ($unit->chapters as $chapter)
                                    <div class="mb-7 w-full md:w-[45%] lg:w-[30%] p-2 mx-2 bg-white  rounded-xl">
                                        <div class="full">
                                            <a class="cursor-pointer h-full flex flex-col justify-between"
                                                href="{{ route('teacher.lessons.index', $chapter->id) }}">
                                                <div class="overflow-hidden">
                                                    {{-- @if ($chapter->image)
                                                        <img src="{{ asset($chapter->image) }}"
                                                            class="object-contain w-full rounded-xl"
                                                            alt="{{ $chapter->name }}">
                                                    @else
                                                        <img src="https://via.placeholder.com/150"
                                                            class="object-contain w-full h-[250px] rounded-xl"
                                                            alt="No Image">
                                                    @endif --}}
                                                    <img src="{{ $chapter->image ? asset($chapter->image) : asset('images/defaultCard.webp') }}"
                                                        alt="{{ $chapter->title }}"
                                                        class="object-contain w-full h-[250px] rounded-xl">
                                                </div>
                                                <div class="p-2">
                                                    <p class="text-slate-800 text-2xl font-semibold truncate">
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