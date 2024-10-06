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

                        <!-- Class Selection -->
                        {{-- <div class="mb-3">
                            <label for="class_ids" class="form-label">Classes</label>
                            <select name="class_id[]" id="class_id" class="form-control" multiple required>

                                @foreach ($classes as $class)

                                <option value="{{ $class->class->id }}" selected>{{ $class->class->name }}</option>


                                @endforeach
                                @foreach ($classess as $cls)
                                <option value="{{ $cls->id }}">{{ $cls->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="mb-3">
                            <label for="class_ids" class="form-label">Classes</label>
                            <select name="class_id[]" id="class_id" class="form-control" multiple required>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}"
                                        {{ in_array($class->id, $teacher->classes->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*">
                            @if ($teacher->image)
                                <p>Current Image: <img src="{{ asset($teacher->image) }}" alt="Teacher Image"
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // let classSelectO = $('#class_id');
            // let classSelectOptions = $('#class_id option');



            $('#stage_ids').select2({
                placeholder: "Select Stages",
                allowClear: true
            });
            $('#class_id').select2({
                placeholder: "Select Classes",
                allowClear: true
            });

            $('#school_id').on('change', function() {
                let schoolId = this.value;
                if (schoolId) {
                    fetch(`/admin/api/schools/${schoolId}/stages`)
                        .then(response => response.json())
                        .then(data => {
                            let stageSelect = $('#stage_ids');
                            stageSelect.empty();
                            $.each(data, function(key, value) {
                                stageSelect.append(
                                    `<option value="${value.id}">${value.name}</option>`);
                            });
                            stageSelect.prop('disabled', false);
                        });

                    fetch(`/admin/api/schools/${schoolId}/classes`)
                        .then(response => response.json())
                        .then(data => {
                            let classSelect = $('#class_id');
                            classSelect.empty();
                            $.each(data, function(key, value) {
                                classSelect.append(
                                    `<option value="${value.id}">${value.name}</option>`);
                            });
                            classSelect.prop('disabled', false);
                        });
                } else {
                    $('#stage_ids').prop('disabled', true);
                    $('#class_id').prop('disabled', true);
                }
            });

            // if ($('#school_id').val() != null) {
            //     let schoolId = $('#school_id').val();
            //     $('#school_id').change();
            //     var selectedItems =[];
            //     console.log($('#school_id').val());
            //     var value = $.map(classSelectOptions, function(option) {
            //     selectedItems.push(option.value);
            //         console.log(option)
            //         // console.log(selectedItems)
            //         // classSelectOptions.append(
            //         //     `<option value="${value.id}">${value.name}</option>`);
            //     });
            //     console.log(selectedItems);
            //     $('#class_id').select2('val',selectedItems );
            // }

        });
    </script>
@endsection
