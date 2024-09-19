@extends('pages.student.student')

@section('title')
    Theme
@endsection


@php
    $paths = [
        ["name" => "Theme", "url" => "student.theme"]
    ];
    $cards = [
        ["title" => "roro", "url" => "student.unit"],
        ["title" => "toto", "url" => "student.unit"],
        ["title" => "toto", "url" => "student.unit"],
        ["title" => "toto", "url" => "student.unit"],
        ["title" => "toto", "url" => "student.unit"],
        ["title" => "toto", "url" => "student.unit"],
        ["title" => "toto", "url" => "student.unit"]
    ]
@endphp

@section("insideContent")
    @include('components.path', ["paths" => $paths])
    @include('components.cards', ["cards" => $cards])
@endsection
