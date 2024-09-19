@extends('pages.student.student')

@section("title")
Theme
@endsection

@section("content")

  @include('components.profile')

  @include('components.AssignmentForms', ['paths' => ['Assignment','Assugnment Name']])
@endsection

