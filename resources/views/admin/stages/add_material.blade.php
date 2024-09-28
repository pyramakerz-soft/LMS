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
                            <h3>Create Theme</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('material.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="stage_id" value="{{ $stage->id }}">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Theme Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                required>
                                            @error('title')
                                                <div class="text-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-6">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Theme Image</label>
                                            <input type="file" class="form-control" id="image" name="image">
                                            @error('image')
                                                <div class="text-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div> --}}

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Upload New Image</label>
                                        <input type="file" name="image" class="form-control" id="image"
                                            accept="image/*">
                                        @error('image')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <button type="button" class="btn btn-secondary" id="chooseFromLibraryButton">
                                            Choose from Library
                                        </button>
                                        <input type="hidden" name="existing_image" id="existing_image" value="">
                                    </div>

                                    <div id="image-preview-container" style="display: none;">
                                        <h5>Selected Image Preview:</h5>
                                        <img id="image-preview" src="" alt="Selected Image"
                                            style="max-width: 200px; border-radius: 8px; box-shadow: 0px 0px 5px #ccc;">
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="file_path" class="form-label">Upload Info </label>
                                            <input type="file" name="file_path" class="form-control" id="file_path"
                                                required>
                                            @error('file_path')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="how_to_use" class="form-label">Upload how to use </label>
                                            <input type="file" name="how_to_use" class="form-control" id="how_to_use"
                                                required>
                                            @error('how_to_use')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="learning" class="form-label">Upload learning outcomes </label>
                                            <input type="file" name="learning" class="form-control" id="learning"
                                                required>
                                            @error('learning')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Active </label>
                                    <input type="checkbox" id="is_active" name="is_active" value="1">
                                    @error('is_active')
                                        <div class="text-danger">{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Create Theme</button>
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
                                            <label for="material_id" class="form-label">Select Theme</label>
                                            <select class="form-control" id="material_id" name="material_id" required>
                                                <option value="">-- Select Theme --</option>
                                                @foreach ($materials as $material)
                                                    <option value="{{ $material->id }}">{{ $material->title }}
                                                    </option>
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
                                    <label for="is_active" class="form-label">Active </label>
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
                                            <label for="material_id" class="form-label">Select Theme</label>
                                            <select class="form-control" id="material_id" name="material_id" required>
                                                <option value="">-- Select Theme --</option>
                                                @foreach ($materials as $material)
                                                    <option value="{{ $material->id }}">{{ $material->title }}
                                                    </option>
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
                                    <label for="is_active" class="form-label">Active </label>
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

<div class="modal fade" id="imageLibraryModal" tabindex="-1" aria-labelledby="imageLibraryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageLibraryModalLabel">Choose an Image from Library</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach ($images as $image)
                        <div class="col-md-3 mb-3">
                            <div class="card image-option" style="cursor: pointer;" data-path="{{ $image->path }}">
                                <img src="{{ asset('storage/' . $image->path) }}" alt="Image"
                                    class="card-img-top img-thumbnail selectable-image"
                                    style="width: 100%; height: 150px; object-fit: cover;">
                                <div class="card-body text-center">
                                    <button class="btn btn-sm btn-primary select-image-button"
                                        type="button">Select</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@section('page_js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chooseFromLibraryButton = document.getElementById('chooseFromLibraryButton');
            const existingImageInput = document.getElementById('existing_image');
            const imagePreviewContainer = document.getElementById('image-preview-container');
            const imagePreview = document.getElementById('image-preview');

            chooseFromLibraryButton.addEventListener('click', function() {
                const modal = new bootstrap.Modal(document.getElementById('imageLibraryModal'), {
                    keyboard: false
                });
                modal.show();
            });

            document.querySelectorAll('.select-image-button').forEach(button => {
                button.addEventListener('click', function() {
                    const imageCard = this.closest('.image-option');
                    const imagePath = imageCard.getAttribute('data-path');

                    existingImageInput.value = imagePath;

                    updateImagePreview("{{ asset('storage') }}/" + imagePath);

                    const modal = bootstrap.Modal.getInstance(document.getElementById(
                        'imageLibraryModal'));
                    modal.hide();
                });
            });

            function updateImagePreview(src) {
                if (src) {
                    imagePreview.src = src;
                    imagePreviewContainer.style.display = 'block';
                } else {
                    imagePreviewContainer.style.display = 'none';
                }
            }

            const newImageInput = document.getElementById('image');
            newImageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        updateImagePreview(e.target.result);
                        existingImageInput.value =
                            "";
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    updateImagePreview(null);
                }
            });
        });
    </script>
@endsection
