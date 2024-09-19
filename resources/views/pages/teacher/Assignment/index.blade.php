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
  @include('components.profile', ['name' => 'menna' , 'subText'=>'class1'] )

  @include('components.table', ['paths' => ['tableData' => $tableData]])
@endsection

