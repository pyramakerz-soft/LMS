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
    <div class="p-5">
        <div class="rounded-lg flex items-center justify-between py-3 px-6 bg-[#2E3646]">
            <div class="flex items-center space-x-4">
                <div>
                    <img class="w-20 h-20 rounded-full" alt="avatar1" src="{{ $userAuth->image }}" />
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
    <div class="p-2 text-[#667085] my-8">
        <i class="fa-solid fa-house mx-2"></i>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="#" class="mx-2 cursor-pointer">Theme</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>

        <a href="#" class="mx-2 cursor-pointer">Unit</a>

    </div>
    <div class="flex flex-wrap">

        <div id="accordion-collapse " class="w-full p-5">

            <div class="mb-5 ">

<<<<<<< HEAD
                <h2 id="accordion-collapse-heading-1">
                    <button type="button" class="accordion-button flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0  focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-1" aria-expanded="false" aria-controls="accordion-collapse-body-1">
                        <span>Unit 1 beginner Level</span>
                        <svg data-accordion-icon class="w-3 h-3 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
                    <div class="flex  flex-wrap items-center justify-start">
    
                        @foreach ($material->units as $unit)
                  <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
                      <div class="h-[350px] bg-white shadow-md border border-slate-200 rounded-md">
                          <a class="cursor-pointer" href="{{ route('student_chapters.index', $unit->id) }}">
                              @if ($unit->image)
                                  <img src="{{ asset('storage/' . $unit->image) }}" class="card-img-top"
                                      alt="{{ $unit->name }}">
                              @else
                                  <img src="https://via.placeholder.com/150" class="card-img-top" alt="No Image">
                              @endif
                              <p class="py-5 px-2 text-slate-800 text-2xl font-semibold">
                                  {{ $unit->title }}
                              </p>
                          </a>
                      </div>
                  </div>
                         @endforeach
    
=======
                @foreach ($material->units as $unit)
                    <h2 id="accordion-collapse-heading-{{ $unit->id }}">
                        <button type="button"
                            class="accordion-button flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
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
                        <div class="flex flex-wrap items-center justify-start">
                            @foreach ($unit->chapters as $chapter)
                                <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
                                    <div class="bg-white shadow-md border border-slate-200 rounded-md">
                                        <a class="cursor-pointer" href="{{ route('student_lessons.index', $chapter->id) }}">
                                            <div class="overflow-hidden">
                                                @if ($chapter->image)
                                                    <img src="{{ asset('storage/' . $chapter->image) }}"
                                                        class="w-full h-full object-fit" alt="{{ $chapter->name }}">
                                                @else
                                                    <img src="https://via.placeholder.com/150"
                                                        class="w-full h-full object-fit" alt="No Image">
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
>>>>>>> efd5f46e7f818eb5cd999cc23e8711adf68c04e5
                    </div>
                @endforeach

            </div>

            {{-- <div class="mb-5">

                <h2 id="accordion-collapse-heading-2">
                    <button type="button"
                        class="accordion-button flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                        data-accordion-target="#accordion-collapse-body-2" aria-expanded="false"
                        aria-controls="accordion-collapse-body-2">
                        <span>Unit 2 Intermediate Level</span>
                        <svg data-accordion-icon class="w-3 h-3 shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
                    <div class="flex flex-wrap items-center justify-start">
                        @foreach ($material->units as $unit)
                            <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
                                <div class=" bg-white shadow-md border border-slate-200 rounded-md">
                                    <a class="cursor-pointer" href="{{ route('student_chapters.index', $unit->id) }}">
                                        <div class=" overflow-hidden">
                                            @if ($unit->image)
                                                <img src="{{ asset('storage/' . $unit->image) }}"
                                                    class="w-full h-full object-fit" alt="{{ $unit->name }}">
                                            @else
                                                <img src="https://via.placeholder.com/150" class="w-full h-full object-fit"
                                                    alt="No Image">
                                            @endif
                                        </div>
                                        <div class="p-2">
                                            <p class="text-slate-800 text-2xl font-semibold ">
                                                {{ $unit->title }}
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>

            <div class="mb-5"> 

                <h2 id="accordion-collapse-heading-3">
                    <button type="button"
                        class="accordion-button flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                        data-accordion-target="#accordion-collapse-body-3" aria-expanded="false"
                        aria-controls="accordion-collapse-body-3">
                        <span>Unit 3 Advanced Level</span>
                        <svg data-accordion-icon class="w-3 h-3 shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <div class="flex flex-wrap items-center justify-start">
                        @foreach ($material->units as $unit)
                            <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
                                <div class=" bg-white shadow-md border border-slate-200 rounded-md">
                                    <a class="cursor-pointer" href="{{ route('student_chapters.index', $unit->id) }}">
                                        <div class=" overflow-hidden">
                                            @if ($unit->image)
                                                <img src="{{ asset('storage/' . $unit->image) }}"
                                                    class="w-full h-full object-fit" alt="{{ $unit->name }}">
                                            @else
                                                <img src="https://via.placeholder.com/150"
                                                    class="w-full h-full object-cover" alt="No Image">
                                            @endif
                                        </div>
                                        <div class="p-2">
                                            <p class="text-slate-800 text-2xl font-semibold ">
                                                {{ $unit->title }}
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


            </div> --}}



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
