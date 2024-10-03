@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">
                    <h1>Classes</h1>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Button to create a new student -->
                    <a href="{{ route('classes.create') }}" class="btn btn-primary mb-3">Add class</a>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>School</th>
                                <th>Grade</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classes as $class)
                                <tr>
                                    <td>{{ $class->name }}</td>
                                    <td>{{ $class->school->name }}</td>
                                    <td>{{ $class->stage->name }}</td>
                                    <td>
                                        <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-info">Edit</a>

                                        <!-- Delete button -->
                                        <form action="{{ route('classes.destroy', $class->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this class?');">
                                                Delete
                                            </button>
                                        </form>

                                        <!-- Import Students Button -->
                                        <a href="{{ route('classes.import', $class->id) }}" class="btn btn-secondary">Import Students</a>
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
