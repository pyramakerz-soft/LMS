@extends('pages.student.student')

@section('title')
    Chapter
@endsection


@php
    $paths = [
        ["name" => "Assignment", "url" => "student.assignment"],
    ];
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

@section("insideContent")
    @include('components.path', ["paths" => $paths])
    @include('components.table', ['paths' => ['tableData' => $tableData]])      
@endsection
