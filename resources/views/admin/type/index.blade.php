@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">
                    <h1>Types</h1>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <a href="{{ route('types.create') }}" class="btn btn-primary mb-3">Add New Type</a>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>type</th>

                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($types as $type)
                                <tr>

                                    <td>{{ $type->name }}</td>

                                    <td>
                                        <a href="{{ route('types.edit', $type->id) }}" class="btn btn-info">Edit</a>

                                        <!-- Delete button -->
                                        <form action="{{ route('types.destroy', $type->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this type?');">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                {{ $types->links('pagination::bootstrap-5') }}

            </main>

            @include('admin.layouts.footer')
        </div>
    </div>
@endsection
