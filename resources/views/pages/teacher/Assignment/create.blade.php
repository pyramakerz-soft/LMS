@extends('pages.teacher.teacher')

@section("title")
  Create Assignment
@endsection

@section("InsideContent")

@php

    $paths = [
      ["name" => "Assignment", "url" => "teacher.Assignment"],
      ["name" => "Assignment Name", "url" => "teacher.Assignment.create"],
    ];
@endphp


  @include('components.AssignmentForms', ['paths' => $paths])

@endsection

