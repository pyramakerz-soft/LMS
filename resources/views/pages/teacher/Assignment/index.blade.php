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


<div class="">


  <div class="flex justify-between">


    @include('components.path', ['paths' => $paths])

    <!-- Create Button Wrapped in Link -->
    <a href="{{ route('teacher.Assignment.create') }}">
        <button class="w-[99.13px] h-[55.47px] rounded-[11.23px] py-[11.23px] px-[21.06px] bg-[#17253E] text-white border-none mt-4">
            Create
        </button>
        
    </a>



  </div>

  @include('components.table', ['paths' => ['tableData' => $tableData]])


</div>

@endsection

