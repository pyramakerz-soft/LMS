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
                                <option selected disabled hidden></option>
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
                                <option selected disabled hidden></option>
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
                            <select name="class_id" id="class_id" class="form-control"
                                data-selected-class="{{ $student->class_id }}" required>
                                <option selected disabled hidden>Select Class</option>
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
        document.addEventListener('DOMContentLoaded', function() {
            let schoolId = document.getElementById('school_id').value;
            let stageId = document.getElementById('stage_id').value;
            let classId = document.getElementById('class_id').dataset.selectedClass;

            if (schoolId) {
                fetchStages(schoolId, stageId); // Load stages based on selected school
            }

            if (stageId) {
                fetchClasses(schoolId, stageId, classId); // Load classes based on selected stage and school
            }
        });

        document.getElementById('school_id').addEventListener('change', function() {
            let schoolId = this.value;
            let stageSelect = document.getElementById('stage_id');
            let classSelect = document.getElementById('class_id');

            // Clear the stage and class dropdowns
            stageSelect.innerHTML = '<option value="" selected disabled hidden>Select Stage</option>';
            classSelect.innerHTML = '<option value="" selected disabled hidden>Select Class</option>';

            if (schoolId) {
                fetchStages(schoolId);
            }
        });

        document.getElementById('stage_id').addEventListener('change', function() {
            let schoolId = document.getElementById('school_id').value;
            let stageId = this.value;
            let classSelect = document.getElementById('class_id');

            classSelect.innerHTML = '<option value="" selected disabled hidden>Select Class</option>';

            if (schoolId && stageId) {
                fetchClasses(schoolId, stageId);
            }
        });

        function fetchStages(schoolId, selectedStageId = null) {
            let stageSelect = document.getElementById('stage_id');

            fetch(`{{ route('admin.schools.stages', ':school') }}`.replace(':school', schoolId))
                .then(response => response.json())
                .then(data => {
                    data.forEach(stage => {
                        let option = document.createElement('option');
                        option.value = stage.id;
                        option.textContent = stage.name;

                        // Pre-select the stage if it matches the existing value
                        if (selectedStageId && stage.id == selectedStageId) {
                            option.selected = true;
                        }

                        stageSelect.appendChild(option);
                    });
                });
        }

        function fetchClasses(schoolId, stageId, selectedClassId = null) {
            let classSelect = document.getElementById('class_id');

            fetch(`{{ route('admin.schools.stages.classes', [':school', ':stage']) }}`
                    .replace(':school', schoolId)
                    .replace(':stage', stageId))
                .then(response => response.json())
                .then(data => {
                    data.forEach(cls => {
                        let option = document.createElement('option');
                        option.value = cls.id;
                        option.textContent = cls.name;

                        // Pre-select the class if it matches the existing value
                        if (selectedClassId && cls.id == selectedClassId) {
                            option.selected = true;
                        }

                        classSelect.appendChild(option);
                    });
                });
        }
    </script>
@endsection
