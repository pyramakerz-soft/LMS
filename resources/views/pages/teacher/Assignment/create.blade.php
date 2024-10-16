@extends('layouts.app')
@section('title')
    Teacher
@endsection
@php
    $menuItems = [['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')]];
@endphp

@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection

@section('content')
    <div class="p-3">
        <div class="rounded-lg flex items-center justify-between py-3 px-6 bg-[#2E3646]">
            <div class="flex items-center space-x-4">
                <div>
                    @if ($userAuth->image)
                        <img src="{{ asset($userAuth->image) }}" alt="Student Image"
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
        </div>
    </div>

    <div class="p-3">
        <div class="text-[#667085] my-8">
            <i class="fa-solid fa-house mx-2"></i>
            <span class="mx-2 text-[#D0D5DD]">/</span>
            <a href="{{ route('assignments.index') }}" class="mx-2 cursor-pointer">Assignment</a>
            <span class="mx-2 text-[#D0D5DD]">/</span>
            <a href="#" class="mx-2 cursor-pointer">Create Assignment</a>
        </div>
    </div>

    <div class="p-3">
        <div>
            <h1 class="font-semibold text-2xl md:text-3xl">Create Assignment</h1>
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
        <form action="{{ route('assignments.store') }}" method="POST" enctype="multipart/form-data" class="mt-5">
            @csrf
            <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
                <label for="title"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C]">Assignment Title</label>
                <input type="text" name="title"
                    class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="title"
                    value="{{ old('title') }}" required>

                <label for="description"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Assignment
                    Description</label>
                <textarea name="description"
                    class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="summernote">{{ old('description') }}</textarea>

                <label for="start_date"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Start Date</label>
                <input type="date" name="start_date"
                    class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base"
                    id="start_date" value="{{ old('start_date') }}">

                <label for="due_date" class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Due
                    Date</label>
                <input type="date" name="due_date"
                    class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base"
                    id="due_date" value="{{ old('due_date') }}">

                <label for="week"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Select Week</label>
                <select name="week" id="week"
                    class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" required>
                    <option value="">--Select Week--</option>

                    <option value="1">week 1</option>
                    <option value="2">week 2</option>
                    <option value="3">week 3</option>
                    <option value="4">week 4</option>
                    <option value="5">week 5</option>
                    <option value="6">week 6</option>
                    <option value="7">week 7</option>
                    <option value="8">week 8</option>

                </select>
                <label for="stage_id"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Select Stage</label>
                <select name="stage_id" id="stage_id"
                    class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" required>
                    <option value="">--Select Stage--</option>
                    @foreach ($stages as $stage)
                        <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                    @endforeach
                </select>

                <label for="class_ids"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Select
                    Classes</label>
                <select name="class_ids[]" id="class_ids"
                    class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" multiple required>
                    <option value="">--Select Classes--</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>

                <label for="lesson_id"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Select Lesson</label>
                <select name="lesson_id" id="lesson_id"
                    class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" required>
                    <option value="">--Select Lesson--</option>
                    @foreach ($lessons as $lesson)
                        <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                    @endforeach
                </select>

                <label for="marks"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Marks</label>
                <input type="number" name="marks" min="1"
                    class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base"
                    id="marks" value="{{ old('marks') }}">

                <label for="path_file"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">File Upload</label>
                <input type="file" name="path_file"
                    class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base"
                    id="path_file" accept=".xlsx, .xls">

                <label for="link"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Link</label>
                <input type="url" name="link"
                    class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base"
                    id="link" value="{{ old('link') }}">

                <div class="flex items-center mt-5">
                    <input type="checkbox" name="is_active"
                        class="form-check-input block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-3"
                        id="is_active" value="1">
                    <label class="form-check-label ml-3" for="is_active">Active</label>
                </div>

                <button type="submit"
                    class="bg-[#17253E] mt-5 text-white font-bold text-xs md:text-sm py-2 md:py-3 px-4 md:px-5 rounded-lg">Create
                    Assignment</button>
            </div>
        </form>
    </div>
@endsection

@section('page_js')
    <script>
        $(document).ready(function() {
            $('#class_ids').select2({
                placeholder: "Select Classes",
                allowClear: true
            });
        });
    </script>
@endsection
