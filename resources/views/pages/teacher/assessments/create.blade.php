@extends('layouts.app')

@section('title')
    Add Student Assessment
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
            <a href="{{ route('assessments.index') }}" class="mx-2 cursor-pointer">Assessments</a>
            <span class="mx-2 text-[#D0D5DD]">/</span>
            <a href="#" class="mx-2 cursor-pointer">Add Student Assessment</a>
        </div>
    </div>

    <div class="p-3">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('assessments.store') }}" method="POST">
            @csrf

            @foreach ($students as  $i => $student)
                <div class="">
                    <div class="">
                        {{ $student->username }} ({{ $student->school->name }}, {{ $student->stage->name }})
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="assessments[{{ $loop->index }}][student_id]"
                            value="{{ $student->id }}">

                        <div class="mb-3">
                            <label for="attendance_score_{{ $student->id }}" class="form-label">Attendance Score (Max
                                10)</label>
                            <input type="number" name="assessments[{{ $loop->index }}][attendance_score]"
                                id="attendance_score_{{ $student->id }}" class="form-control" max="10">
                        </div>

                        <div class="mb-3">
                            <label for="classroom_participation_score_{{ $student->id }}" class="form-label">Classroom
                                Participation Score (Max 15)</label>
                            <input type="number" name="assessments[{{ $loop->index }}][classroom_participation_score]"
                                id="classroom_participation_score_{{ $student->id }}" class="form-control" max="15">
                        </div>

                        <div class="mb-3">
                            <label for="classroom_behavior_score_{{ $student->id }}" class="form-label">Classroom Behavior
                                Score (Max 15)</label>
                            <input type="number" name="assessments[{{ $loop->index }}][classroom_behavior_score]"
                                id="classroom_behavior_score_{{ $student->id }}" class="form-control" max="15">
                        </div>

                        <div class="mb-3">
                            <label for="homework_score_{{ $student->id }}" class="form-label">Homework Score (Max
                                10)</label>
                            <input type="number" name="assessments[{{ $loop->index }}][homework_score]"
                                id="homework_score_{{ $student->id }}" class="form-control" max="10">
                        </div>

                        <div class="mb-3">
                            <label for="final_project_score_{{ $student->id }}" class="form-label">Final Project Score
                                (Max 50)
                            </label>
                            <input type="number" name="assessments[{{ $loop->index }}][final_project_score]"
                                id="final_project_score_{{ $student->id }}" class="form-control" max="50">
                        </div>
                    </div>
                </div>
                @if($i !== count($students) - 1)
                    <hr class="border-[#ff751967] border-2 rounded-xl">
                @endif
            @endforeach

            <button type="submit" class="btn btn-primary">Submit Assessments</button>
        </form>
    </div>

@endsection
