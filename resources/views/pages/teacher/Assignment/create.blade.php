@extends('pages.student.student')

@section("title")
  Create Assignment
@endsection

@section("content")

<div class="p-4">
  @include('components.profile', ['name' => 'menna' , 'subText'=>'class1' , "image" => "https://mdbcdn.b-cdn.net/img/new/avatars/9.webp"] )

  @include('components.AssignmentForms', ['paths' => ['Assignment','Assugnment Name']])

</div>
@endsection

