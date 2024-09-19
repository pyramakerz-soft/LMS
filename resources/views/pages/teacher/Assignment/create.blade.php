@extends('pages.student.student')

@section("title")
  Create Assignment
@endsection

@section("content")

@php

    $paths = [
        ["name" => "Theme", "url" => "student.theme"],
        ["name" => "Unit", "url" => "student.unit"],
        ["name" => "Chapter", "url" => "student.chapter"],
    ]; // Example of paths
@endphp

<div class="p-4">
  @include('components.profile', ['name' => 'menna' , 'subText'=>'class1' , "image" => "https://mdbcdn.b-cdn.net/img/new/avatars/9.webp"] )

  @include('components.AssignmentForms', ['paths' => $paths])

</div>
@endsection

