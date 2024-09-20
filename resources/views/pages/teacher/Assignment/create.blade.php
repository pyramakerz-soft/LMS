@extends('pages.teacher.teacher')

@section("title")
  Create Assignment
@endsection

@section("InsideContent")

@php

    $paths = [
      ["name" => "Assignment", "url" => "teacher.Assignment"],
      ["name" => "AssignmentName", "url" => "teacher.Assignment.create"],
    ]; // Example of paths
@endphp


  @include('components.AssignmentForms', ['paths' => $paths])

@endsection

