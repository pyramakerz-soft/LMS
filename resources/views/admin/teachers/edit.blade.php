@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">
                    <h1>Edit Teacher</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('teachers.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control"
                                value="{{ $teacher->username }}" required>
                        </div>

                        <!-- Gender -->
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-control" required>
                                <option value="boy" {{ $teacher->gender == 'boy' ? 'selected' : '' }}>Boy</option>
                                <option value="girl" {{ $teacher->gender == 'girl' ? 'selected' : '' }}>Girl</option>
                            </select>
                        </div>

                        <!-- School -->
                        <div class="mb-3">
                            <label for="school_id" class="form-label">School</label>
                            <select name="school_id" id="school_id" class="form-control" required>
                                <option value="">-- Select School --</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}"
                                        {{ $teacher->school_id == $school->id ? 'selected' : '' }}>
                                        {{ $school->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Stage Selection -->
                        <div class="mb-3">
                            <label for="stage_ids" class="form-label">Stages</label>
                            <select name="stage_ids[]" id="stage_ids" class="form-control" multiple required>
                                @foreach ($stages as $stage)
                                    <option value="{{ $stage->id }}"
                                        {{ in_array($stage->id, $teacher->stages->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $stage->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*">
                            @if ($teacher->image)
                                <p>Current Image: <img src="{{ asset( $teacher->image) }}" alt="Teacher Image"
                                        width="100"></p>
                            @endif
                        </div>

                        <!-- Active -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1"
                                {{ $teacher->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Teacher</button>
                    </form>
                </div>
            </main>

            @include('admin.layouts.footer')
        </div>
    </div>
@endsection

@section('page_js')
    <script>
        document.getElementById('school_id').addEventListener('change', function() {
            let schoolId = this.value;
            if (schoolId) {
                fetch(`/api/schools/${schoolId}/stages`)
                    .then(response => response.json())
                    .then(data => {
                        let stageSelect = document.getElementById('stage_ids');
                        stageSelect.innerHTML = '';
                        data.forEach(stage => {
                            stageSelect.innerHTML +=
                                `<option value="${stage.id}">${stage.name}</option>`;
                        });
                        stageSelect.disabled = false; // Enable the stage select input
                    });
            } else {
                document.getElementById('stage_ids').disabled = true; // Disable the select if no school is selected
            }
        });
    </script>
@endsection
