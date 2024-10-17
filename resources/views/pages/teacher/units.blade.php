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

    <style>
        .breadcrumb {
            padding: 12px;
            color: #667085;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .breadcrumb span {
            color: #D0D5DD;
        }

        .breadcrumb a {
            color: inherit;
            text-decoration: none;
            cursor: pointer;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            padding: 16px;
        }

        .unit {
            width: 100%;
            margin: 16px;
        }

        .accordion-button {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 8px;
            background-color: #f0f0f0;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .accordion-button:hover {
            background-color: #2E3646;
            color: white;
        }

        .unit-header {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .unit-image {
            width: 50px;
            height: 44px;
            border-radius: 2px;
        }

        .unit-title {
            font-size: 1.5rem;
            margin-top: 4px;
        }

        .accordion-icon {
            width: 16px;
            height: 16px;
            transition: transform 0.3s;
        }

        .accordion-body {
            display: none;
            padding: 16px;
        }

        .accordion-body.hidden {
            display: block;
        }

        .chapters {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }

        .chapter {
            width: 100%;
            max-width: 30%;
            padding: 8px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .chapter-link {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            text-decoration: none;
        }

        .chapter-image {
            width: 100%;
            height: 250px;
            object-fit: contain;
            border-radius: 12px;
        }

        .chapter-title {
            padding: 8px;
            font-size: 1.5rem;
            color: #2d3748;
            text-align: center;
        }
    </style>

    <div class="breadcrumb">
        <i class="fa-solid fa-house"></i>
        <span>/</span>
        <a href="{{ route('teacher.dashboard') }}">Grade</a>
        <span>/</span>
        <a href="{{ route('teacher.info', $material->stage_id) }}">Info</a>
        <span>/</span>
        <a href="{{ route('teacher.showMaterials', $material->stage_id) }}">Theme</a>
        <span>/</span>
        <a href="">Units</a>
    </div>

    <div class="container">
        <div id="accordion-collapse">
            @foreach ($material->units as $unit)
                <div class="unit">
                    <h2 id="accordion-collapse-heading-{{ $unit->id }}">
                        <button type="button" class="accordion-button" 
                            data-accordion-target="#accordion-collapse-body-{{ $unit->id }}"
                            aria-expanded="false" aria-controls="accordion-collapse-body-{{ $unit->id }}">
                            <div class="unit-header">
                                @if ($loop->iteration == 1)
                                    <img src="{{ asset('images/unit1.png') }}" class="unit-image">
                                @elseif ($loop->iteration == 2)
                                    <img src="{{ asset('images/unit2.png') }}" class="unit-image">
                                @else
                                    <img src="{{ asset('images/unit3.png') }}" class="unit-image">
                                @endif
                                <span class="unit-title">{{ $unit->title }}</span>
                            </div>
                            <svg class="accordion-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 5 5 1 1 5" />
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-collapse-body-{{ $unit->id }}" class="accordion-body">
                        <div class="chapters">
                            @foreach ($unit->chapters as $chapter)
                                <div class="chapter">
                                    <a href="{{ route('teacher.lessons.index', $chapter->id) }}" class="chapter-link">
                                        <img src="{{ $chapter->image ? asset($chapter->image) : asset('images/defaultCard.webp') }}"
                                            alt="{{ $chapter->title }}" class="chapter-image">
                                        <div class="chapter-title">{{ $chapter->title }}</div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <script>
            document.querySelectorAll('.accordion-button').forEach(button => {
                button.addEventListener('click', () => {
                    const accordionBody = document.querySelector(button.getAttribute('data-accordion-target'));
                    const icon = button.querySelector('svg');

                    accordionBody.classList.toggle('hidden');
                    icon.classList.toggle('rotate-180');
                });
            });
        </script>
    </div>
@endsection
