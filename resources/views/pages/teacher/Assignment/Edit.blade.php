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
    <div class="container">
        <div class="m-5">
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

  <form action="{{ route('assignments.update', $assignment->id) }}" method="POST" enctype="multipart/form-data" class="m-5 ">
      @csrf
      @method('PUT')

      <!-- Select School -->
      <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
          <label for="school_id" class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C]">Select School</label>
          <select name="school_id" id="school_id" class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" required>
              <option value="">--Select School--</option>
              @foreach ($schools as $school)
                  <option value="{{ $school->id }}" {{ $assignment->school_id == $school->id ? 'selected' : '' }}>
                      {{ $school->name }}
                  </option>
              @endforeach
          </select>
      </div>

      <!-- Select Stage (pre-fill the existing stage) -->
      <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
          <label for="stage_id" class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C]">Select Stage</label>
          <select name="stage_id" id="stage_id" class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" required>
              <option value="">--Select Stage--</option>
              @foreach ($stages as $stage)
                  <option value="{{ $stage->id }}" {{ $selectedStage == $stage->id ? 'selected' : '' }}>
                      {{ $stage->name }}
                  </option>
              @endforeach
          </select>
      </div>

      <!-- Select Students (pre-fill the existing students) -->
      <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
          <label for="student_ids" class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C]">Select Students</label>
          <select name="student_ids[]" id="student_ids" class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" multiple required>
              <option value="">--Select Students--</option>
              @foreach ($students as $student)
                  <option value="{{ $student->id }}"
                      {{ in_array($student->id, $selectedStudents) ? 'selected' : '' }}>
                      {{ $student->username }}
                  </option>
              @endforeach
          </select>
      </div>

      <!-- Other fields (title, description, file, etc.) -->
      <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
          <label for="title" class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C]">Assignment Title</label>
          <input type="text" name="title" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="title" value="{{ $assignment->title }}"
              required>
      </div>

      <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
          <label for="description" class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C]">Assignment Description</label>
          <textarea name="description" class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="summernote">{{ $assignment->description }}</textarea>
      </div>
      <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
          <label for="lesson_id" class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C]">Select Lesson</label>
          <select name="lesson_id" id="lesson_id" class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" required>
              <option value="">--Select Lesson--</option>
              @foreach ($lessons as $lesson)
                  <option value="{{ $lesson->id }}" {{ $assignment->lesson_id == $lesson->id ? 'selected' : '' }}>
                      {{ $lesson->title }}
                  </option>
              @endforeach
          </select>
      </div>

      <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
          <label for="path_file" class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C]">File Upload</label>
          <input type="file" name="path_file" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="path_file">
          @if ($assignment->path_file)
              <p>Current File: <a href="{{ asset('storage/' . $assignment->path_file) }}">Download</a></p>
          @endif
      </div>

      <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
          <label for="link" class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C]">Link</label>
          <input type="url" name="link" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="link" value="{{ $assignment->link }}">
      </div>

      <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
          <label for="start_date" class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C]">Start Date</label>
          <input type="date" name="start_date" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="start_date"
              value="{{ $assignment->start_date }}">
      </div>

      <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
          <label for="due_date" class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C]">Due Date</label>
          <input type="date" name="due_date" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="due_date"
              value="{{ $assignment->due_date }}">
      </div>

      <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
          <label for="marks" class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C]">Marks</label>
          <input type="number" name="marks" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="marks" value="{{ $assignment->marks }}">
      </div>

      <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F] form-check  flex items-center">
          <input type="checkbox" name="is_active" class="form-check-input block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-3 " id="is_active" value="1"
              {{ $assignment->is_active ? 'checked' : '' }}>
          <label class="form-check-label ml-3" for="is_active">Active</label>
      </div>

      <button type="submit" class="bg-[#17253E] text-white font-bold text-xs md:text-sm py-2 md:py-3 px-4 md:px-5 rounded-lg m-5">Update Assignment</button>
  </form>
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
