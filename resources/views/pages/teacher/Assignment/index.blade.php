@extends('pages.student.student')

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
@endphp



@section("content")
<div class="p-4">

  @include('components.profile', ['name' => 'menna' , 'subText'=>'class1' , "image" => "https://mdbcdn.b-cdn.net/img/new/avatars/9.webp"] )

  <div class="flex justify-between p-3">
    @include('components.path', ['paths' => ['tableData' ,'tww']])

    <button class="w-[99.13px] h-[60.47px] rounded-[11.23px] py-[11.23px] px-[21.06px] bg-[#17253E] text-white border-none">
        Create
    </button>


  </div>

  @include('components.table', ['paths' => ['tableData' => $tableData]])
</div>

@endsection

