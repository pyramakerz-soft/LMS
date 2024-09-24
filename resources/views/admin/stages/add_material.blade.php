@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <main class="content">
                <div class="container-fluid p-0">
                    <h1>Add Material</h1>

                    <!-- Material Form -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3>Create Material</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('material.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="stage_id" value="{{ $stage->id }}">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Material Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                required>
                                            @error('title')
                                                <div class="text-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Material Image</label>
                                            <input type="file" class="form-control" id="image" name="image">
                                            @error('image')
                                                <div class="text-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Active Status</label>
                                    <input type="checkbox" id="is_active" name="is_active" value="1">
                                    @error('is_active')
                                        <div class="text-danger">{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Create Material</button>
                            </form>
                        </div>
                    </div>

                    <!-- Unit Form -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3>Create Unit</h3>

                        </div>
                        <div class="card-body">
                            <form action="{{ route('units.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Unit Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="material_id" class="form-label">Select Material</label>
                                            <select class="form-control" id="material_id" name="material_id" required>
                                                <option value="">-- Select Material --</option>
                                                @foreach ($materials as $material)
                                                    <option value="{{ $material->id }}">{{ $material->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Unit Image</label>
                                            <input type="file" class="form-control" id="image" name="image">
                                        </div>
                                    </div>
                                </div>




                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Active Status</label>
                                    <input type="checkbox" id="is_active" name="is_active" value="1">
                                </div>
                                <button type="submit" class="btn btn-primary">Create Unit</button>
                            </form>
                        </div>
                    </div>

                    <!-- Chapter Form -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3>Create Chapter</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('chapters.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Chapter Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="material_id" class="form-label">Select Material</label>
                                            <select class="form-control" id="material_id" name="material_id" required>
                                                <option value="">-- Select Material --</option>
                                                @foreach ($materials as $material)
                                                    <option value="{{ $material->id }}">{{ $material->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="unit_id" class="form-label">Select Unit</label>
                                            <select class="form-control" id="unit_id" name="unit_id" required>
                                                <option value="">-- Select Unit --</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Chapter Image</label>
                                            <input type="file" class="form-control" id="image" name="image">
                                        </div>
                                    </div>
                                </div>




                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Active Status</label>
                                    <input type="checkbox" id="is_active" name="is_active" value="1">
                                </div>
                                <button type="submit" class="btn btn-primary">Create Chapter</button>
                            </form>
                        </div>
                    </div>

                </div>
            </main>

            @include('admin.layouts.footer')
        </div>
    </div>
@endsection
