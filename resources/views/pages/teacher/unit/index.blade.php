@extends('pages.teacher.teacher')

@section('title')
    Theme
@endsection


@php
    $paths = [
        ["name" => "Grade", "url" => "teacher.theme"],
        ["name" => "info", "url" => "teacher.material"],
        ["name" => "Theme", "url" => "teacher.theme"],
        ["name" => "unit", "url" => "teacher.unit"],


    ];
    $cards = [
        ["title" => "material", "url" => "teacher.chapter"],
        ["title" => "material", "url" => "teacher.chapter"],
        ["title" => "material", "url" => "teacher.chapter"],
        ["title" => "material", "url" => "teacher.chapter"],
        ["title" => "material", "url" => "teacher.chapter"],
        ["title" => "material", "url" => "teacher.chapter"],
        ["title" => "material", "url" => "teacher.chapter"]
    ]
@endphp

@section("InsideContent")
    @include('components.path', ["paths" => $paths])
    @include('components.cards', ["cards" => $cards])
@endsection
