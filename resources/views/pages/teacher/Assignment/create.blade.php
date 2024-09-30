@extends('layouts.app')

@section('title')
    Teacher
@endsection

@php
    $menuItems = [
        ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('student.theme')],
        ['label' => 'Assignment', 'icon' => 'fas fa-home', 'route' => route('student.assignment')],
    ];

@endphp
@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection


@section('content')
    <div class="container">
        <div class="m-5">
            <h1 class="font-semibold text-2xl md:text-3xl ">Create Assignment</h1>

        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('assignments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
                <label for="school_id" class="form-label  block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C]">Select
                    School</label>
                <select name="school_id" id="school_id"
                    class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" required>
                    <option value="">--Select School--</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
                <label for="stage_id"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Select Stage</label>
                <select name="stage_id" id="stage_id"
                    class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" required>
                    <option value="">--Select Stage--</option>
                </select>
            </div>

            <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
                <label for="student_ids"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Select
                    Students</label>
                <select name="student_ids[]" id="student_ids"
                    class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" multiple required>
                    <option value="">--Select Students--</option>
                </select>
            </div>
            <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
                <label for="title"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Assignment
                    Title</label>
                <input type="text" name="title"
                    class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="title"
                    value="{{ old('title') }}" required>
            </div>

            <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
                <label for="description"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Assignment
                    Description</label>
                <textarea name="description"
                    class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="summernote">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
                <label for="path_file"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">File Upload</label>
                <input type="file" name="path_file"
                    class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base"
                    id="path_file">
            </div>

            <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
                <label for="link"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Link</label>
                <input type="url" name="link"
                    class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base"
                    id="link" value="{{ old('link') }}">
            </div>

            <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
                <label for="start_date"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Start Date</label>
                <input type="date" name="start_date"
                    class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base"
                    id="start_date" value="{{ old('start_date') }}">
            </div>

            <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
                <label for="due_date" class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Due
                    Date</label>
                <input type="date" name="due_date"
                    class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base"
                    id="due_date" value="{{ old('due_date') }}">
            </div>

            <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
                <label for="lesson_id"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Select Lesson</label>
                <select name="lesson_id" id="lesson_id"
                    class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" required>
                    @foreach ($lessons as $lesson)
                        <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                    @endforeach
                </select>
            </div>


            <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
                <label for="marks"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Marks</label>
                <input type="number" name="marks"
                    class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base"
                    id="marks" value="{{ old('marks') }}">
            </div>

            <div
                class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F] form-check  flex items-center">
                <input type="checkbox" name="is_active"
                    class="form-check-input block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-3 " id="is_active"
                    value="1">
                <label class="form-check-label ml-3" for="is_active ">Active</label>
            </div>

            <button type="submit"
                class="bg-[#17253E] text-white font-bold text-xs md:text-sm py-2 md:py-3 px-4 md:px-5 rounded-lg m-5">Create
                Assignment</button>
        </form>
    </div>
@endsection
@section('page_js')
    <script>
        document.getElementById('school_id').addEventListener('change', function() {
            let schoolId = this.value;
            fetch(`/teacher/api/schools/${schoolId}/stages`)
                .then(response => response.json())
                .then(data => {
                    let stageSelect = document.getElementById('stage_id');
                    stageSelect.innerHTML = '<option value="">--Select Stage--</option>';
                    data.forEach(stage => {
                        stageSelect.innerHTML += `<option value="${stage.id}">${stage.name}</option>`;
                    });
                });
        });

        document.getElementById('stage_id').addEventListener('change', function() {
            let stageId = this.value;
            fetch(`/teacher/api/stages/${stageId}/students`)
                .then(response => response.json())
                .then(data => {
                    let studentSelect = document.getElementById('student_ids');
                    studentSelect.innerHTML = '<option value="">--Select Students--</option>';
                    data.forEach(student => {
                        studentSelect.innerHTML +=
                            `<option value="${student.id}">${student.username}</option>`;
                    });
                });
        });
    </script>
    {{-- <script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 200
        });
    });
</script> --}}
@endsection
