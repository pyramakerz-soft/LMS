@extends('pages.student.student')

@section("title")
Theme
@endsection

@section("content")

  @include('components.profile', ['name' => 'menna' , 'subText'=>'class1'] )

  @include('components.AssignmentForms', ['paths' => ['Assignment','Assugnment Name']])
@endsection

