@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1>Materials</h1>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- <a href="{{ route('material.create') }}" class="btn btn-primary mb-3">Add Material</a> --}}

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Grade</th>
                                <th>Image</th>
                                <th>Ebook info</th>
                                <th>Ebook learning</th>
                                <th>Ebook how to use</th>
                                <th>Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materials as $material)
                                <tr>
                                    <td>{{ $material->title }}</td>
                                    <td>{{ $material->stage->name }}</td>
                                    <td>
                                        @if ($material->image)
                                            <img src="{{ asset( $material->image) }}" alt="{{ $material->title }}"
                                                width="100">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td><a href="{{ $material->file_path }}" > File info</a>   </td>
                                    <td><a href="{{ $material->learning }}" > Learning</a></td>
                                    <td><a href="{{ $material->how_to_use }}" > How to use</a></td>
                                    <td>{{ $material->is_active ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                        <a href="{{ route('material.edit', $material->id) }}" class="btn btn-info">Edit</a>
                                        <form action="{{ route('material.destroy', $material->id) }}" method="POST"
                                            style="display:inline;">
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
