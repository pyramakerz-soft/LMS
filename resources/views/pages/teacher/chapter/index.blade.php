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
        ["name" => "Chapter", "url" => "teacher.chapter"],


    ];
    $cards = [
        ["title" => "material", "url" => "teacher.lesson"],
        ["title" => "material", "url" => "teacher.lesson"],
        ["title" => "material", "url" => "teacher.lesson"],
        ["title" => "material", "url" => "teacher.lesson"],
        ["title" => "material", "url" => "teacher.lesson"],
        ["title" => "material", "url" => "teacher.lesson"],
        ["title" => "material", "url" => "teacher.lesson"]
    ]
@endphp

@section("InsideContent")
    @include('components.path', ["paths" => $paths])
    @include('components.cards', ["cards" => $cards])
@endsection
