@extends('pages.teacher.teacher')

@section("title")
Theme
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
        // Add more data as needed
    ];

    $paths = [
        ["name" => "Assignment", "url" => "teacher.Assignment"],
    ]; // Example of paths

@endphp



@section("InsideContent")


<div class="p-4">


  <div class="flex justify-between p-3">


    @include('components.path', ['paths' => $paths])

    <button class="w-[99.13px] h-[60.47px] rounded-[11.23px] py-[11.23px] px-[21.06px] bg-[#17253E] text-white border-none">
        Create
    </button>


  </div>

  @include('components.table', ['paths' => ['tableData' => $tableData]])


</div>

@endsection

