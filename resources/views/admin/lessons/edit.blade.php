@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">
                    <h1>Edit Lesson</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('lessons.update', $lesson->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Lesson Title</label>
                            <input type="text" name="title" class="form-control" id="title"
                                value="{{ $lesson->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="chapter_id" class="form-label">Select Chapter</label>
                            <select name="chapter_id" id="chapter_id" class="form-control" required>
                                @foreach ($chapters as $chapter)
                                    <option value="{{ $chapter->id }}"
                                        {{ $lesson->chapter_id == $chapter->id ? 'selected' : '' }}>
                                        {{ $chapter->material->stage->name }} / {{ $chapter->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <div class="mb-3">
                            <label for="image" class="form-label">Lesson Image</label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*">
                            @if ($lesson->image)
                                <p>Current Image:</p>

                                <img src="{{ asset( $lesson->image) }}" alt="{{ $lesson->title }}"
                                    width="100">
                            @endif
                        </div> --}}

                        <div class="mb-3">
                            <label for="image" class="form-label">Lesson Image</label>
                        
                            <!-- Display the current image if it exists -->
                            @if ($lesson->image)
                                <div class="mb-2">
                                    <img src="{{ asset($lesson->image) }}" alt="{{ $lesson->title }}" id="imagePreview" width="150" class="mb-2 rounded">
                                </div>
                            @endif
                        
                            <!-- Image input field -->
                            <input type="file" name="image" class="form-control" id="image" accept="image/*" onchange="previewNewImage(event)">
    
                        </div>

 
                        <!-- Changed file input to select input -->
                        <div class="mb-3">
                            <label for="file_path" class="form-label">Select Ebook</label>
                            <select name="file_path" class="form-control" id="file_path">
                                @foreach (\App\Models\Ebook::all() as $ebook)
                                    <option value="{{ $ebook->file_path }}"
                                        {{ $lesson->file_path == $ebook->file_path ? 'selected' : '' }}>
                                        {{ $ebook->title }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($lesson->file_path)
                               <button type="button" class="btn btn-success" data-bs-toggle="modal" 
                                                data-bs-target="#ebookModal" 
                                                data-file="{{ asset($lesson->file_path) }}">
                                            View Ebook
                                        </button>
                                        
 
                            @endif
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1"
                                {{ $lesson->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Lesson</button>
                    </form>
                </div>
            </main>
            <div class="modal fade" id="ebookModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-width: 90%; max-height: 90%; margin: auto;">
            <div class="modal-content" style="height: 90vh;">
                <div class="modal-header">
                    <h5 class="modal-title">Ebook</h5>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                <div class="modal-body" style="height: calc(100% - 60px);">
                    <embed src="" id="ebookEmbed" width="100%" height="100%" style="border: none;"></embed>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
    
@endsection

@section('page_js')
    <script>
        $(document).ready(function() {
            // Handle the event when the modal is about to be shown
            $('#ebookModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var file = button.data('file'); // Extract the file path from data-file attribute
                // file='https://pyramakerz-artifacts.com/LMS/lms_pyramakerz/public/ebooks/G1%20-%20Urban%20city%20Un1.%20Ch1.L1/'

                var modal = $(this);
                var embed = modal.find('#ebookEmbed');

                console.log(file);
                
                // Set the src attribute of the embed to the eBook file path
                embed.attr('src', file);
            });

            // Clear the embed src when the modal is hidden to stop the loading
            $('#ebookModal').on('hide.bs.modal', function() {
                var embed = $(this).find('#ebookEmbed');
                embed.attr('src', '');
            });
        });
    </script>
@endsection

@section('page_js')
<script>
    // JavaScript function to show the new image preview when a file is selected
    function previewNewImage(event) {
        const imageFile = event.target.files[0];  // Get the selected file
        const reader = new FileReader();  // Create a FileReader to read the file

        reader.onload = function(e) {
            const imagePreview = document.getElementById('imagePreview');  // Get the current image element

            // If an image preview exists, update its src
            if (imagePreview) {
                imagePreview.src = e.target.result;  // Update image source to the new image
            } else {
                // If no image preview exists, create one dynamically
                const newImage = document.createElement('img');
                newImage.id = 'imagePreview';
                newImage.src = e.target.result;
                newImage.width = 150;
                newImage.classList.add('rounded', 'mb-2');
                document.getElementById('image').insertAdjacentElement('beforebegin', newImage);
            }
        };

        // Read the file and trigger the preview update
        if (imageFile) {
            reader.readAsDataURL(imageFile);
        }
    }

    document.getElementById('changeFileButton')?.addEventListener('click', function() {
        // Show the file input field when "Change File" button is clicked
        const fileInput = document.getElementById('file_path');
        fileInput.style.display = 'block';  // Show the file input
        this.style.display = 'none';  // Hide the "Change File" button
    });
</script>
@endsection