@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1>Lessons</h1>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <a href="{{ route('lessons.create') }}" class="btn btn-primary mb-3">Add Lesson</a>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>File</th>
                                <th>Chapter</th>
                                <th>Image</th>
                                <th>Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lessons as $lesson)
                                <tr>
                                    <td>{{ $lesson->title }}</td>
                                    <td>
                                        <a href="{{ route('lesson.view', $lesson->id) }}" target="_blank"
                                            class="btn btn-success">View
                                            Ebook</a>
                                    </td>
                                    <td>{{ $lesson->chapter->title }}</td>
                                    <td>
                                        @if ($lesson->image)
                                            <img src="{{ asset('storage/' . $lesson->image) }}" alt="{{ $lesson->title }}"
                                                width="100">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>{{ $lesson->is_active ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                        <a href="{{ route('lessons.edit', $lesson->id) }}" class="btn btn-info">Edit</a>
                                        <form action="{{ route('lessons.destroy', $lesson->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </main>

            @include('admin.layouts.footer')
        </div>
    </div>
@endsection
