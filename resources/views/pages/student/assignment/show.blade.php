@extends('pages.student.student')

@section('title')
    Chapter
@endsection


@php
    $paths = [
        ["name" => "Assignment", "url" => "student.assignment"],
        ["name" => "Assignment Name", "url" => "student.assignment.show"],
    ];
    $data = [
        'point' => '95',
        'dueDate' => '2024-10-01',
        'topic' => 'Mathematics',
        'assignTo' => 'Class A',
        'title' => 'Homework Assignment',
        'description' => 'Solve the problems in chapter 5.',
        'uploadedFileName' => 'homework.pdf',
    ];
@endphp

@section("insideContent")
    @include('components.path', ["paths" => $paths])
    @include('components.AssignmentDetails', ['paths' =>$paths  ,  $data])
@endsection
