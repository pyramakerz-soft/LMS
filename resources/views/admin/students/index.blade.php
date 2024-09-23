@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">
                    <h1>Students</h1>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Button to create a new student -->
                    <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">Add Student</a>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Gender</th>
                                <th>School</th>
                                <th>Stage</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td>
                                        @if ($student->image)
                                            <img src="{{ asset('storage/' . $student->image) }}" alt="Student Image"
                                                width="50" height="50" class="rounded-circle">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>{{ $student->username }}</td>
                                    <td>{{ $student->plain_password }}</td>
                                    <td>{{ ucfirst($student->gender) }}</td>
                                    <td>{{ $student->school->name }}</td>
                                    <td>{{ $student->stage->name }}</td>
                                    <td>
                                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-info">Edit</a>

                                        <!-- Delete button -->
                                        <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this student?');">
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
