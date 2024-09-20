@extends('pages.teacher.teacher')

@section("title")
  Create Assignment
@endsection

@section("InsideContent")

@php
    $data = [
        'point' => '95',
        'dueDate' => '2024-10-01',
        'topic' => 'Mathematics',
        'assignTo' => 'Class A',
        'title' => 'Homework Assignment',
        'description' => 'Solve the problems in chapter 5.',
        'uploadedFileName' => 'homework.pdf', // Example of an uploaded file name
    ];

    $paths = [
        ["name" => "Assignment", "url" => "teacher.Assignment"],
        ["name" => "AssignmentName", "url" => "teacher.assignment.edit"],
    ]; // Example of paths
@endphp


  @include('components.AssignmentEdit', ['paths' => $paths ,  $data])

</div>
@endsection

