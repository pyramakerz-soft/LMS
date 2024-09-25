@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1>Chapters</h1>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- <a href="{{ route('chapters.create') }}" class="btn btn-primary mb-3">Add Chapter</a> --}}


                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Unit</th>
                                <th>Material</th>
                                <th>Stage</th> <!-- Add stage column -->
                                <th>Image</th>
                                <th>Is Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($chapters as $chapter)
                                <tr>
                                    <td>{{ $chapter->title }}</td>
                                    <td>{{ $chapter->unit->title }}</td>
                                    <td>{{ $chapter->material->title }}</td>
                                    <td>{{ $chapter->material->stage->name }}</td> <!-- Add stage name -->
                                    <td>
                                        @if ($chapter->image)
                                            <img src="{{ asset('storage/' . $chapter->image) }}" alt="{{ $chapter->title }}"
                                                width="100">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>{{ $chapter->is_active ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                        <a href="{{ route('chapters.edit', $chapter->id) }}" class="btn btn-info">Edit</a>
                                        <form action="{{ route('chapters.destroy', $chapter->id) }}" method="POST"
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
