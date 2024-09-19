@extends('pages.student.student')

@section("title")
  Create Assignment
@endsection

@section("content")

  @include('components.profile', ['name' => "Ahmed Mohamed", "subText" => "Grade: 1 - Class A1", "image" => "https://mdbcdn.b-cdn.net/img/new/avatars/9.webp"])

  @include('components.AssignmentForms', ['paths' => ['Assignment','Assugnment Name']])
@endsection

