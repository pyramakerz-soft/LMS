@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1>Edit Stage</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('stages.update', $stage->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Stage Name</label>
                            <input type="text" name="name" class="form-control" id="name"
                                value="{{ $stage->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Stage Image</label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*">
                            @if ($stage->image)
                                <p>Current Image:</p>
                                <img src="{{ asset('storage/' . $stage->image) }}" alt="{{ $stage->name }}" width="100">
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">Update Stage</button>
                    </form>

                </div>
            </main>

            @include('admin.layouts.footer')
        </div>
    </div>
@endsection