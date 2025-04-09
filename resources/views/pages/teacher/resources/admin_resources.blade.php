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
            padding: 2px 6px;
            font-size: 12px;
            border-radius: 4px;
            background-color: #eee;
            display: inline-block;
            margin-top: 5px;
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
        {{-- <h2 class="mb-4"> Resources</h2> --}}

        <h4>Lesson Resources</h4>
        <div class="row">
            @forelse ($lessonResources as $res)
                <div class="col-md-3">
                    <div class="resource-card">
                        <h5>{{ $res->title }}</h5>
                        <span class="resource-type">{{ strtoupper($res->type) }}</span>
                        <p><strong>Lesson:</strong> {{ $res->lesson->title ?? 'N/A' }}</p>
                        <a href="{{ asset($res->path) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary mt-2">View</a>
                    </div>
                </div>
            @empty
                <p class="text-muted">No lesson resources found.</p>
            @endforelse
        </div>

        <hr>

        <h4>Theme Resources</h4>
        <div class="row">
            @forelse ($themeResources as $res)
                <div class="col-md-3">
                    <div class="resource-card">
                        <h5>{{ $res->title }}</h5>
                        <span class="resource-type">{{ strtoupper($res->type) }}</span>
                        <p><strong>Theme:</strong> {{ $res->material->title ?? 'N/A' }}</p>
                        <a href="{{ asset($res->path) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary mt-2">View</a>
                    </div>
                </div>
            @empty
                <p class="text-muted">No theme resources found.</p>
            @endforelse
        </div>
    </div>
@endsection
