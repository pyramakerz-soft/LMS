@extends('pages.teacher.teacher')

@section("title")
    Assignment
@endsection

@php

$tableData = [
        [
            'title' => 'Task 1',
            'dueDate' => '2024-09-30',
            'desc' => 'Description for Task 1',
        ],
        [
            'title' => 'Task 2',
            'dueDate' => '2024-10-05',
            'desc' => 'Description for Task 2',
        ],
    ];

    $paths = [
        ["name" => "Assignment", "url" => "teacher.Assignment"],
    ];

@endphp



@section("InsideContent")

    <div class="">
    <div class="flex justify-between items-center">
        @include('components.path', ['paths' => $paths])

        <a href="{{ route('teacher.Assignment.create') }}">
            <button class="rounded-md px-5 py-3 bg-[#17253E] text-white border-none">
                Create
            </button>
        </a>
    </div>
    @include('components.table', ['paths' => ['tableData' => $tableData]])
    </div>

@endsection

