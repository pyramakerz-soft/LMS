{{-- @extends('layouts.admin')

@section('content') --}}
<div class="container">
    <h1>Stages</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('stages.create') }}" class="btn btn-primary mb-3">Add Stage</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Stage Name</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stages as $stage)
                <tr>
                    <td>{{ $stage->name }}</td>
                    <td>
                        @if ($stage->image)
                            <img src="{{ asset('storage/' . $stage->image) }}" alt="{{ $stage->name }}" width="100">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('stages.edit', $stage->id) }}" class="btn btn-info">Edit</a>
                        <form action="{{ route('stages.destroy', $stage->id) }}" method="POST"
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
{{-- @endsection --}}
