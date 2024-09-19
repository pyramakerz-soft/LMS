@extends('pages.student.student')

@section("title")
  Create Assignment
@endsection

@section("content")

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
        ["name" => "Theme", "url" => "student.theme"],
        ["name" => "Unit", "url" => "student.unit"],
        ["name" => "Chapter", "url" => "student.chapter"],
    ]; // Example of paths
@endphp


<div class="p-4">
  @include('components.profile', ['name' => 'menna' , 'subText'=>'class1' , "image" => "https://mdbcdn.b-cdn.net/img/new/avatars/9.webp"] )

  @include('components.AssignmentEdit', ['paths' => $paths ,  $data])

</div>
@endsection

