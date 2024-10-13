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

                    <!-- Add table-fixed class for fixed width -->
                    <table class="table table-bordered table-fixed">
                        <thead>
                            <tr>
                                <th style="width: 20%">Name</th>
                                <th style="width: 20%">Address</th>
                                <th style="width: 10%">City</th>
                                <th style="width: 10%">Type</th>
                                <th style="width: 10%">Students Count</th>
                                <th style="width: 30%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schools as $school)
                                <tr>
                                    <td>{{ $school->name ?? '-' }}</td>
                                    <td>{{ $school->address ?? '-' }}</td>
                                    <td>{{ $school->city ?? '-' }}</td>
                                    <td>{{ $school->type->name ?? '-' }}</td>
                                    <td>{{ $school->students->count() ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('admins.edit', $school->id) }}" class="btn btn-info">Edit</a>
                                        <form action="{{ route('admins.destroy', $school->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>

                                        <!-- Button to assign curriculum -->
                                        <a href="{{ route('school.curriculum.assign', $school->id) }}"
                                            class="btn btn-success">Add Curriculum</a>

                                        <!-- New Button to view curriculum -->
                                        <a href="{{ route('school.curriculum.view', $school->id) }}"
                                            class="btn btn-primary">View Curriculum</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </main>

             
        </div>
    </div>
@endsection

<!-- Add CSS for table-fixed class -->
<style>
    .table-fixed {
        table-layout: fixed;
        width: 100%;
    }

    .table-fixed th, .table-fixed td {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>
