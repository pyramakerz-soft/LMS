@extends('pages.teacher.teacher')

@section("title")
  Create Assignment
@endsection

@section("InsideContent")

@php

    $paths = [
        ["name" => "Theme", "url" => "student.theme"],
        ["name" => "Unit", "url" => "student.unit"],
        ["name" => "Chapter", "url" => "student.chapter"],
    ]; // Example of paths
@endphp


  @include('components.AssignmentForms', ['paths' => $paths])

@endsection

