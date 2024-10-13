@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1>Units</h1>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Add scrollable wrapper for horizontal scroll -->
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Material</th>
                                    <th>Image</th>
                                    <th>Active</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($units as $unit)
                                    <tr>
                                        <td>{{ $unit->title }}</td>
                                        <td>{{ $unit->material->title ?? ' '}}</td>
                                        <td>
                                            @if ($unit->image)
                                                <img src="{{ asset( $unit->image) }}" alt="{{ $unit->title }}"
                                                    width="100">
                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        <td>{{ $unit->is_active ? 'Active' : 'Inactive' }}</td>
                                        <td class="d-flex justify-content-start">
                                            <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-info">Edit</a>
                                            <form action="{{ route('units.destroy', $unit->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" style="margin-left: 10px;">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- End of scrollable wrapper -->

                </div>
            </main>

        </div>
    </div>
@endsection
