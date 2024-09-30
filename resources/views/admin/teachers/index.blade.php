@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">
                    <h1>Teachers</h1>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Button to create a new teacher -->
                    <a href="{{ route('teachers.create') }}" class="btn btn-primary mb-3">Add New Teacher</a>
                    <!-- Add New Teacher Button -->

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Profile image</th>
                                <th>Username</th>
                                <th>Gender</th>
                                <th>School</th>
                                <th>Plain Password</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teachers as $teacher)
                                <tr>
                                    <td>
                                        @if ($teacher->image)
                                            <img src="{{ asset( $teacher->image) }}" alt="Tracher Image"
                                                width="50" height="50" class="rounded-circle">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>{{ $teacher->username }}</td>
                                    <td>{{ ucfirst($teacher->gender) }}</td>
                                    <td>{{ $teacher->school->name }}</td>
                                    <td>{{ $teacher->plain_password }}</td>
                                    <td>
                                        <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-info">Edit</a>

                                        <!-- Delete button -->
                                        <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this teacher?');">
                                                Delete
                                            </button>
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
