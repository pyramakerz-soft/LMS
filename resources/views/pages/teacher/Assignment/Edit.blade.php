@extends('layouts.app')
@section('title')
    Teacher
@endsection
@php
    $menuItems = [
        ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')],
        ['label' => 'Assignments', 'icon' => 'fas fa-home', 'route' => route('assignments.index')],
    ];
@endphp
@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection

@section('content')
    <div class="p-3">
        <div class="rounded-lg flex items-center justify-between py-3 px-6 bg-[#2E3646]">
            <div class="flex items-center space-x-4">
                <div>
                    {{-- <img class="w-20 h-20 rounded-full" alt="avatar1" src="{{ Auth::guard('student')->user()->image }}" /> --}}
                    @if ($userAuth->image)
                        <img src="{{ asset('storage/' . $userAuth->image) }}" alt="Student Image"
                            class="w-20 h-20 rounded-full object-cover">
                    @else
                        <img src="{{ asset('storage/students/profile-png.webp') }}" alt="Student Image"
                            class="w-30 h-20 rounded-full object-cover">
                    @endif
                </div>

                <div class="ml-3 font-semibold text-white flex flex-col space-y-2">
                    <div class="text-xl">
                        {{ $userAuth->username }}
                    </div>
                </div>
            </div>

            <div class="relative">
                <i class="fa-solid fa-bell text-[#FF7519] text-xl"></i>
                <span
                    class="absolute -top-2 -right-2 bg-black border-2 border-white text-white rounded-full text-[10px] px-1 py-0.25">5</span>
            </div>
        </div>
    </div>

    <div class="p-3">
        <div class="text-[#667085] my-8">
            <i class="fa-solid fa-house mx-2"></i>
            <span class="mx-2 text-[#D0D5DD]">/</span>
            <a href="{{ route('assignments.index') }}" class="mx-2 cursor-pointer">Assignment</a>
            <span class="mx-2 text-[#D0D5DD]">/</span>
            <a href="#" class="mx-2 cursor-pointer">Edit Assignment</a>
        </div>
    </div>

    <div class="p-3">
        <div>
            <div>
                <h1 class="font-semibold text-2xl md:text-3xl ">Edit Assignment</h1>
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

            <form action="{{ route('assignments.update', $assignment->id) }}" method="POST" enctype="multipart/form-data"
                class="mt-5">
                @csrf
                @method('PUT')

                <!-- Select School -->
                <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
                    <label for="title"
                        class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] ">Assignment
                        Title</label>
                    <input type="text" name="title"
                        class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="title"
                        value="{{ $assignment->title }}" required>

                    <label for="description"
                        class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Assignment
                        Description</label>
                    <textarea name="description"
                        class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="summernote">{{ $assignment->description }}</textarea>

                        <label for="start_date"
                        class="form-label mt-5 block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C]">Start
                        Date</label>
                    <input type="date" name="start_date"
                        class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="start_date"
                        value="{{ $assignment->start_date }}">

                    <label for="due_date"
                        class="form-label mt-5 block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C]">Due
                        Date</label>
                    <input type="date" name="due_date"
                        class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="due_date"
                        value="{{ $assignment->due_date }}">

                    <label for="school_id"
                        class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Select
                        School</label>
                    <select name="school_id" id="school_id"
                        class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" required>
                        <option value="">--Select School--</option>
                        @foreach ($schools as $school)
                            <option value="{{ $school->id }}"
                                {{ $assignment->school_id == $school->id ? 'selected' : '' }}>
                                {{ $school->name }}
                            </option>
                        @endforeach
                    </select>

                    <label for="stage_id"
                        class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Select
                        Stage</label>
                    <select name="stage_id" id="stage_id"
                        class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" required>
                        <option value="">--Select Stage--</option>
                        @foreach ($stages as $stage)
                            <option value="{{ $stage->id }}" {{ $selectedStage == $stage->id ? 'selected' : '' }}>
                                {{ $stage->name }}
                            </option>
                        @endforeach
                    </select>

                    <label for="student_ids"
                        class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Select
                        Students</label>
                    <select name="student_ids[]" id="student_ids"
                        class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" multiple required>
                        <option value="">--Select Students--</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}"
                                {{ in_array($student->id, $selectedStudents) ? 'selected' : '' }}>
                                {{ $student->username }}
                            </option>
                        @endforeach
                    </select>

                    <label for="lesson_id"
                        class="form-label block mb-3 font-semibold mt-5 text-xs md:text-sm text-[#3A3A3C]">Select
                        Lesson</label>
                    <select name="lesson_id" id="lesson_id"
                        class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" required>
                        <option value="">--Select Lesson--</option>
                        @foreach ($lessons as $lesson)
                            <option value="{{ $lesson->id }}"
                                {{ $assignment->lesson_id == $lesson->id ? 'selected' : '' }}>
                                {{ $lesson->title }}
                            </option>
                        @endforeach
                    </select>

                    <label for="marks"
                        class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Marks</label>
                    <input type="number" name="marks"
                        class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="marks"
                        value="{{ $assignment->marks }}">

                    <label for="path_file"
                        class="form-label block mb-3 font-semibold text-xs md:text-sm mt-5 text-[#3A3A3C]">File
                        Upload</label>
                    <input type="file" name="path_file"
                        class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="path_file">
                    @if ($assignment->path_file)
                        <p>Current File: <a href="{{ asset('storage/' . $assignment->path_file) }}">Download</a></p>
                    @endif

                    <label for="link"
                        class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Link</label>
                    <input type="url" name="link"
                        class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="link"
                        value="{{ $assignment->link }}">

                    <div class="flex items-center mt-5">
                        <input type="checkbox" name="is_active"
                            class="form-check-input block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-3 "
                            id="is_active" value="1" {{ $assignment->is_active ? 'checked' : '' }}>
                        <label class="form-check-label ml-3" for="is_active">Active</label>
                    </div>

                    <button type="submit"
                        class="bg-[#17253E] text-white font-bold text-xs md:text-sm py-2 md:py-3 px-4 md:px-5 rounded-lg mt-5">Update
                        Assignment</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('page_js')
    <!-- Include Summernote JS -->
    <script>
        document.getElementById('school_id').addEventListener('change', function() {
            let schoolId = this.value;
            fetch(`/api/schools/${schoolId}/stages`)
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
            fetch(`/api/stages/${stageId}/students`)
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

        $(document).ready(function() {
            $('#summernote').summernote({
                height: 200
            });
        });
    </script>
@endsection
