@extends('admin.layouts.layout')

@section('content')
<div class="wrapper">
    @include('admin.layouts.sidebar')

    <div class="main">
        @include('admin.layouts.navbar')

        <main class="content">
            <div class="container-fluid p-0">

                <h1>Lesson Resources</h1>
                <a href="{{ route('lesson_resource.create') }}" class="btn btn-primary mb-3">Add Resource</a>
                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Filter Form --}}
                <form method="GET" action="{{ route('lesson_resource.index') }}" class="row mb-4" id="filterForm">
                    <div class="col-md-4">
                        <label for="stage_id" class="form-label">Filter by Grade</label>
                        <select name="stage_id" id="stage_id" class="form-control">
                            <option value="">All Grades</option>
                            @foreach ($stages as $stage)
                            <option value="{{ $stage->id }}"
                                {{ request('stage_id') == $stage->id ? 'selected' : '' }}>
                                {{ $stage->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="theme_id" class="form-label">Filter by Theme</label>
                        <select name="theme_id" id="theme_id" class="form-control">
                            <option value="">All Themes</option>
                            @foreach ($themes as $theme)
                            <option value="{{ $theme->id }}"
                                {{ request('theme_id') == $theme->id ? 'selected' : '' }}>
                                {{ $theme->title }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="lesson_id" class="form-label">Filter by Lesson</label>
                        <select name="lesson_id" id="lesson_id" class="form-control">
                            <option value="">All Lesson</option>
                            @foreach ($lessons as $lesson)
                            <option value="{{ $lesson->id }}"
                                {{ request('lesson_id') == $lesson->id ? 'selected' : '' }}>
                                {{ $lesson->chapter->material->title ?? ''}}-{{ $lesson->chapter->unit->title ?? ''}}-{{$lesson->chapter->title ?? ''}}-{{ $lesson->title ?? ''}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </form>


                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>File Type</th>
                                <th>Grade</th>
                                <th>Theme</th>
                                <th>Chapter</th>
                                <th>Unit</th>
                                <th>Lesson</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resources as $resource)
                            <tr>
                                <td>{{ $resource->title }}</td>
                                <td>{{ $resource->type }}</td>
                                <td>{{ $resource->lesson->chapter->unit->material->stage->name }}</td>
                                <td>{{ $resource->lesson->chapter->unit->material->title }}</td>
                                <td>{{ $resource->lesson->chapter->title }}</td>
                                <td>{{ $resource->lesson->chapter->unit->title }}</td>
                                <td>{{ $resource->lesson->title }}</td>
                                <td>{{ $resource->created_at->format('d-m-Y') }}</td>
                                <td class="d-flex align-items-center gap-2">
                                    <form action="{{ route('lesson_resource.destroy', $resource->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this resource?');">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </main>
    </div>
</div>
@endsection
@section('page_js')
<script>
    $(document).ready(function() {
        $('#theme_id, #stage_id, #lesson_id').change(function() {
            $('#filterForm').submit();
        });
    });
</script>
@endsection