@extends('pages.teacher.teacher')

@section('title')
    Theme
@endsection


@php
    $paths = [
        ["name" => "Grade", "url" => "teacher.grade"],
        ["name" => "info", "url" => "teacher.material"]
    ];
    $cards = [
        ["title" => "material", "url" => "student.unit"],
        ["title" => "material", "url" => "student.unit"],
        ["title" => "material", "url" => "student.unit"],
        ["title" => "material", "url" => "student.unit"],
        ["title" => "material", "url" => "student.unit"],
        ["title" => "material", "url" => "student.unit"],
        ["title" => "material", "url" => "student.unit"]
    ]
@endphp

@section("InsideContent")
    @include('components.path', ["paths" => $paths])
    @include('components.cards', ["cards" => $cards])
@endsection
