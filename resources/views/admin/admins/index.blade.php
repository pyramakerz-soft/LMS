@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1>School Admins</h1>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <a href="{{ route('admins.create') }}" class="btn btn-primary mb-3">Add School Admin</a>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>School</th>
                                <th>Students Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                                <tr>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->school->name ?? 'N/A' }}</td>
                                    <td>{{ $admin->school->students->count() ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('admins.edit', $admin->id) }}" class="btn btn-info">Edit</a>
                                        <form action="{{ route('admins.destroy', $admin->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>

                                        <!-- Button to assign curriculum -->
                                        <a href="{{ route('school.curriculum.assign', $admin->school->id) }}"
                                            class="btn btn-success">Add Curriculum</a>

                                        <!-- New Button to view curriculum -->
                                        <a href="{{ route('school.curriculum.view', $admin->school->id) }}"
                                            class="btn btn-primary">View Curriculum</a>
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
