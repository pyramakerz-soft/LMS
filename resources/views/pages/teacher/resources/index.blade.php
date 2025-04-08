@php
    $userAuth = auth()->guard('teacher')->user();
@endphp

@extends('layouts.app')

@section('title', 'Resources')

@section('page_css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .resource-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #fff;
            transition: box-shadow 0.3s ease;
        }

        .resource-card:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .resource-card img {
            max-height: 180px;
            width: 100%;
            object-fit: cover;
            border-radius: 6px;
        }

        .resource-card h3 {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0 5px;
        }

        .resource-card p {
            color: #555;
            font-size: 14px;
        }

        .resource-card .actions {
            margin-top: 10px;
        }

        .filter-form select,
        .filter-form button {
            max-width: 250px;
        }

        .modal-header h5 {
            font-weight: bold;
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

    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>My Resources</h2>
            <div>
                <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#downloadModal">Download
                    Resources</button>
                <a href="{{ route('teacher.resources.create') }}" class="btn btn-primary">Add Resource</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="GET" action="{{ route('teacher.resources.index') }}" class="filter-form mb-4 d-flex gap-2">
            <select id="grade" name="grade" class="form-select">
                <option value="">All Grades</option>
                @foreach ($stages as $stage)
                    <option value="{{ $stage->id }}" {{ request('grade') == $stage->id ? 'selected' : '' }}>
                        {{ $stage->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <div class="row">
            @forelse ($resources as $resource)
                <div class="col-md-3">
                    <div class="resource-card">
                        <a href="{{ asset($resource->file_path) }}" target="_blank">
                            <img src="{{ $resource->image ? asset($resource->image) : asset('assets/img/default.png') }}"
                                alt="{{ $resource->name }}">
                        </a>
                        <h3>{{ $resource->name }}</h3>
                        <p>{{ Str::limit($resource->description, 100) }}</p>
                        <p><strong>Grade:</strong> {{ $resource->stage->name }}</p>

                        <div class="actions d-flex justify-content-between">
                            <a href="{{ route('teacher.resources.edit', $resource->id) }}"
                                class="btn btn-sm btn-success">Edit</a>
                            <form action="{{ route('teacher.resources.destroy', $resource->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center mt-4">No resources available.</p>
            @endforelse
        </div>
    </div>

    <!-- Modal for Download -->
    <div class="modal fade" id="downloadModal" tabindex="-1" aria-labelledby="downloadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="downloadForm" action="{{ route('download.resources') }}" method="POST">
                    @csrf
                    <input type="hidden" name="resource_type" id="resource_type" value="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="downloadModalLabel">Download Resources</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="download_lesson_id" class="form-label">Download by Lesson</label>
                            <select name="download_lesson_id" id="download_lesson_id" class="form-select">
                                <option value="">-- Select Lesson --</option>
                                @foreach ($lessons as $lesson)
                                    <option value="{{ $lesson->id }}">
                                        {{ $lesson->chapter->material->title ?? '' }} -
                                        {{ $lesson->chapter->unit->title ?? '' }} -
                                        {{ $lesson->chapter->title ?? '' }} -
                                        {{ $lesson->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="download_theme_id" class="form-label">Download by Theme</label>
                            <select name="download_theme_id" id="download_theme_id" class="form-select">
                                <option value="">-- Select Theme --</option>
                                @foreach ($themes as $theme)
                                    <option value="{{ $theme->id }}">{{ $theme->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Download as ZIP</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    @section('page_js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const lessonSelect = document.getElementById('download_lesson_id');
                const themeSelect = document.getElementById('download_theme_id');
                const resourceTypeInput = document.getElementById('resource_type');
                const form = document.getElementById('downloadForm');

                lessonSelect.addEventListener('change', function() {
                    if (this.value) themeSelect.value = '';
                });

                themeSelect.addEventListener('change', function() {
                    if (this.value) lessonSelect.value = '';
                });

                form.addEventListener('submit', function(e) {
                    const lessonId = lessonSelect.value;
                    const themeId = themeSelect.value;

                    if (!lessonId && !themeId) {
                        e.preventDefault();
                        alert('Please select a lesson or a theme to download.');
                        return;
                    }

                    if (lessonId && themeId) {
                        e.preventDefault();
                        alert('Please select only one option (Lesson or Theme).');
                        return;
                    }

                    resourceTypeInput.value = lessonId ? 'lesson' : 'theme';
                });
            });
        </script>
    @endsection


@endsection
