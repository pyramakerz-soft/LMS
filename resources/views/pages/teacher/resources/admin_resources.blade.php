@php
    $userAuth = auth()->guard('teacher')->user();
@endphp

@extends('layouts.app')

@section('title', 'Admin Resources')

@section('page_css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .resource-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
            background-color: #fff;
            transition: 0.3s;
            cursor: pointer;

        }

        .resource-card:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .resource-card img {
            max-height: 180px;
            width: 100%;
            object-fit: cover;
            border-radius: 6px;
        }

        .resource-type {
            margin-top: 4px;
            display: inline-block;
            background-color: #f1f1f1;
            color: #333;
            padding: 3px 8px;
            font-size: 12px;
            border-radius: 4px;
        }

        span.title {
            color: #f97233;
        }
    </style>
@endsection

@section('sidebar')
    @include('components.sidebar', [
        'menuItems' => [
            ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')],
            ['label' => 'Resources', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.resources.index')],
            ['label' => 'Ticket', 'icon' => 'fa-solid fa-ticket', 'route' => route('teacher.tickets.index')],
            ['label' => 'Chat', 'icon' => 'fa-solid fa-message', 'route' => route('chat.all')],
        ],
    ])
@endsection

@section('content')
    @include('components.profile')

    <div class="container mt-4">
        <h4>Lesson Resources</h4>
        <div class="row">
            @forelse ($groupedLessons as $lessonId => $resources)
                <div class="col-md-4 mb-4">
                    <div class="resource-card" onclick="toggleDetails('lesson-{{ $lessonId }}')">
                        <h5><strong>Lesson:</strong>
                            <span class="title">
                                {{ $resources->first()->lesson->title ?? 'N/A' }}
                            </span>
                        </h5>
                        <ul class="mt-2 p-0" id="lesson-{{ $lessonId }}" style="display: none;">
                            @foreach ($resources as $res)
                                <li class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <div class="fw-bold">{{ $res->title }}</div>
                                        <div class="resource-type">{{ strtoupper($res->type) }}</div>
                                    </div>
                                    <a href="{{ asset($res->path) }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary ms-3">
                                        {{ strtoupper($res->type) === 'ZIP' ? 'Download' : 'View' }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @empty
                <p class="text-muted">No lesson resources found.</p>
            @endforelse
        </div>

        <hr>

        <h4>Theme Resources</h4>
        <div class="row">
            @forelse ($groupedThemes as $themeId => $resources)
                <div class="col-md-4 mb-4">
                    <div class="resource-card" onclick="toggleDetails('theme-{{ $themeId }}')">
                        <h5><strong>Theme:</strong>
                            <span class="title">
                                {{ $resources->first()->material->title ?? 'N/A' }}

                            </span>
                        </h5>
                        <ul class="mt-2 p-0" id="theme-{{ $themeId }}" style="display: none;">
                            @foreach ($resources as $res)
                                <li class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <div class="fw-bold">{{ $res->title }}</div>
                                        <div class="resource-type">{{ strtoupper($res->type) }}</div>
                                    </div>
                                    <a href="{{ asset($res->path) }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary ms-3">
                                        {{ strtoupper($res->type) === 'ZIP' ? 'Download' : 'View' }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @empty
                <p class="text-muted">No theme resources found.</p>
            @endforelse
        </div>
    </div>
@endsection
@section('page_js')
    <script>
        function toggleDetails(id) {
            const el = document.getElementById(id);
            if (el.style.display === 'none') {
                el.style.display = 'block';
            } else {
                el.style.display = 'none';
            }
        }
    </script>
@endsection
