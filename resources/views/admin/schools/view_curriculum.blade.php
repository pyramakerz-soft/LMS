@extends('admin.layouts.layout')
@section('page_css')
    <style>
        .curriculum-section {
            margin-bottom: 40px;
        }

        .material-card,
        .unit-card,
        .chapter-image {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
            padding: 15px;
        }

        .material-image,
        .unit-image,
        .chapter-image,
        .lesson-image {
            border-radius: 50%;
        }

        .material-card {
            background-color: #f1f3f5;
        }

        .unit-card {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
        }

        .list-group-item {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #dee2e6;
        }
    </style>
@endsection
@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="mb-4">Curriculum for {{ $school->name }}</h1>

                    @if ($curriculum->isEmpty())
                        <div class="alert alert-info">No curriculum has been assigned to this school.</div>
                    @else
                        <!-- Stages Section -->
                        <div class="curriculum-section">
                            <h2 class="text-primary mb-3">Stages</h2>

                            @foreach ($curriculum as $stage)
                                <div class="card mb-4 shadow">
                                    <div class="card-header d-flex align-items-center">
                                        <img src="{{ $stage->image ? Storage::url($stage->image) : asset('images/default-stage.png') }}"
                                            alt="{{ $stage->name }}" class=" me-3" width="100" height="100">
                                        <h3 class="mb-0">{{ $stage->name }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- Materials Section -->
                                        <h4 class="text-secondary mb-2">Materials</h4>
                                        @foreach ($stage->materials as $material)
                                            <div class="material-card mb-3 p-3 bg-light border rounded">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $material->image ? Storage::url($material->image) : asset('images/default-material.png') }}"
                                                        alt="{{ $material->name }}" class="material-image me-3"
                                                        width="100" height="100">
                                                    <h5 class="mb-0">{{ $material->name }}</h5>
                                                </div>

                                                <!-- Units Section -->
                                                <h6 class="text-muted mt-3">Units</h6>
                                                <ul class="list-unstyled">
                                                    @foreach ($material->units as $unit)
                                                        <li class="unit-card mb-2">
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ $unit->image ? Storage::url($unit->image) : asset('images/default-unit.png') }}"
                                                                    alt="{{ $unit->title }}" class="unit-image me-2"
                                                                    width="100" height="100">
                                                                <strong>{{ $unit->title }}</strong>
                                                            </div>

                                                            <!-- Chapters Section -->
                                                            <h6 class="text-muted mt-2">Chapters</h6>
                                                            <ul class="list-group">
                                                                @foreach ($unit->chapters as $chapter)
                                                                    <li class="list-group-item">
                                                                        <div class="d-flex align-items-center">
                                                                            <img src="{{ $chapter->image ? Storage::url($chapter->image) : asset('images/default-chapter.png') }}"
                                                                                alt="{{ $chapter->title }}"
                                                                                class="chapter-image me-2" width="100"
                                                                                height="100">
                                                                            <strong>{{ $chapter->title }}</strong>
                                                                        </div>

                                                                        <!-- Lessons Section -->
                                                                        <h6 class="text-muted mt-2">Lessons</h6>
                                                                        <ul class="list-group list-group-flush">
                                                                            @foreach ($chapter->lessons as $lesson)
                                                                                <li class="list-group-item">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <img src="{{ $lesson->image ? Storage::url($lesson->image) : asset('images/default-lesson.png') }}"
                                                                                            alt="{{ $lesson->title }}"
                                                                                            class="lesson-image me-2"
                                                                                            width="100" height="100">
                                                                                        <span>{{ $lesson->title }}</span>
                                                                                    </div>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </main>

            @include('admin.layouts.footer')
        </div>
    </div>


@endsection
