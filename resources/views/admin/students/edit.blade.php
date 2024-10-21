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
                            <select name="stage_id" id="stage_id" class="form-control"
                                data-selected-stage="{{ $student->stage_id }}" required>
                                <option value="" selected disabled hidden>Select Stage</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="class_id" class="form-label">Class</label>
                            <select name="class_id" id="class_id" class="form-control"
                                data-selected-class="{{ $student->class_id }}" required>
                                <option value="" selected disabled hidden>Select Class</option>
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
            let schoolSelect = document.getElementById('school_id');
            let stageSelect = document.getElementById('stage_id');
            let classSelect = document.getElementById('class_id');
            let selectedStageId = stageSelect.dataset.selectedStage;
            let selectedClassId = classSelect.dataset.selectedClass;

            // Load stages if a school is already selected
            if (schoolSelect.value) {
                fetchStages(schoolSelect.value, selectedStageId);
            }

            // Load classes if both school and stage are already selected
            if (schoolSelect.value && selectedStageId) {
                fetchClasses(schoolSelect.value, selectedStageId, selectedClassId);
            }

            // Event listener when school changes
            schoolSelect.addEventListener('change', function() {
                fetchStages(this.value);
                clearSelect(stageSelect);
                clearSelect(classSelect);
            });

            // Event listener when stage changes
            stageSelect.addEventListener('change', function() {
                let schoolId = schoolSelect.value;
                fetchClasses(schoolId, this.value);
                clearSelect(classSelect);
            });

            // Helper to clear select options
            function clearSelect(selectElement) {
                selectElement.innerHTML = '<option value="" selected disabled hidden>Select</option>';
            }

            // Fetch and populate stages
            function fetchStages(schoolId, selectedStage = null) {
                fetch(`{{ route('admin.schools.stages', ':school') }}`.replace(':school', schoolId))
                    .then(response => response.json())
                    .then(data => {
                        clearSelect(stageSelect);
                        data.forEach(stage => {
                            let option = document.createElement('option');
                            option.value = stage.id;
                            option.textContent = stage.name;
                            if (selectedStage && stage.id == selectedStage) {
                                option.selected = true;
                            }
                            stageSelect.appendChild(option);
                        });
                    });
            }

            // Fetch and populate classes
            function fetchClasses(schoolId, stageId, selectedClass = null) {
                fetch(`{{ route('admin.schools.stages.classes', [':school', ':stage']) }}`
                        .replace(':school', schoolId)
                        .replace(':stage', stageId))
                    .then(response => response.json())
                    .then(data => {
                        clearSelect(classSelect);
                        data.forEach(cls => {
                            let option = document.createElement('option');
                            option.value = cls.id;
                            option.textContent = cls.name;
                            if (selectedClass && cls.id == selectedClass) {
                                option.selected = true;
                            }
                            classSelect.appendChild(option);
                        });
                    });
            }
        });
    </script>
@endsection
