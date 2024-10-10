@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h2>Create Student</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-control" required>
                                <option value="boy">Boy</option>
                                <option value="girl">Girl</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="school_id" class="form-label">School</label>
                            <select name="school_id" id="school_id" class="form-control" required>
                                <option value="">Select School</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Stage Selection -->
                        <div class="mb-3">
                            <label for="stage_id" class="form-label">Grade</label>
                            <select name="stage_id" id="stage_id" class="form-control" required>
                                <option value="">Select Grade</option>
                            </select>
                        </div>

                        <!-- Class Selection -->
                        <div class="mb-3">
                            <label for="class_id" class="form-label">Class</label>
                            <select name="class_id" id="class_id" class="form-control" required>
                                <option value="">Select Class</option>
                            </select>
                        </div>
                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Create Student</button>
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
                fetch(`/LMS/lms_pyramakerz/public/admin/api/schools/${schoolId}/stages`)
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
                fetch(`/LMS/lms_pyramakerz/public/admin/api/stages/${stageId}/classes`)
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
