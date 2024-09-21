{{-- @extends('layouts.admin')

@section('content') --}}
    <div class="container">
        <h1>Create Material</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('material.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}" required>
            </div>

            <div class="mb-3">
                <label for="stage_id" class="form-label">Stage</label>
                <select name="stage_id" class="form-control" id="stage_id" required>
                    @foreach($stages as $stage)
                        <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" class="form-control" id="image" accept="image/*">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1">
                <label class="form-check-label" for="is_active">Is Active</label>
            </div>

            <button type="submit" class="btn btn-primary">Create Material</button>
        </form>
    </div>
{{-- @endsection --}}
