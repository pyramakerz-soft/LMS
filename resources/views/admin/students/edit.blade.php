@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">
                    <h1>Edit Student</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="username"
                                value="{{ $student->username }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" class="form-control" id="gender" required>
                                <option value="boy" {{ $student->gender == 'boy' ? 'selected' : '' }}>Boy</option>
                                <option value="girl" {{ $student->gender == 'girl' ? 'selected' : '' }}>Girl</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="school_id" class="form-label">School</label>
                            <select name="school_id" class="form-control" id="school_id" required>
                                <option value="">Select School</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}"
                                        {{ $student->school_id == $school->id ? 'selected' : '' }}>
                                        {{ $school->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="stage_id" class="form-label">Stage</label>
                            <select name="stage_id" class="form-control" id="stage_id" required>
                                <option value="">Select Stage</option>
                                @foreach ($stages as $stage)
                                    <option value="{{ $stage->id }}"
                                        {{ $student->stage_id == $stage->id ? 'selected' : '' }}>
                                        {{ $stage->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="class_id" class="form-label">Class</label>
                            <select name="class_id" id="class_id" class="form-control" required>
                                <option value="">Select Class</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}"
                                        {{ $student->class_id == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*">
                            @if ($student->image)
                                <p>Current Image: <img class="my-3" src="{{ asset($student->image) }}"
                                        alt="Student Image" width="100"></p>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">Update Student</button>
                    </form>

                </div>
            </main>


        </div>
    </div>
@endsection

@section('page_js')
    <script>
        document.getElementById('school_id').addEventListener('change', function() {
            let schoolId = this.value;
            if (schoolId) {
                fetch(`{{ route('admin.schools.stages', ':school') }}`.replace(':school', schoolId))
                    .then(response => response.json())
                    .then(data => {
                        let stageSelect = document.getElementById('stage_id');
                        stageSelect.innerHTML = '<option value="">Select Grade</option>';
                        data.forEach(stage => {
                            stageSelect.innerHTML +=
                                `<option value="${stage.id}">${stage.name}</option>`;
                        });
                    });
            } else {
                document.getElementById('stage_id').innerHTML = '<option value="">Select Stage</option>';
            }
        });

        document.getElementById('stage_id').addEventListener('change', function() {
            let stageId = this.value;
            if (stageId) {
                fetch(`{{ route('admin.stages.classes', ':stage') }}`.replace(':stage', stageId))
                    .then(response => response.json())
                    .then(data => {
                        let classSelect = document.getElementById('class_id');
                        classSelect.innerHTML = '<option value="">Select Class</option>';
                        data.forEach(cls => {
                            classSelect.innerHTML += `<option value="${cls.id}">${cls.name}</option>`;
                        });
                    });
            } else {
                document.getElementById('class_id').innerHTML = '<option value="">Select Class</option>';
            }
        });
    </script>
@endsection
