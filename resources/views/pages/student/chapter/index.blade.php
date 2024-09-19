@extends('pages.student.student')

@section('title')
    Chapter
@endsection


@php
    $paths = [
        ["name" => "Theme", "url" => "student.theme"],
        ["name" => "Unit", "url" => "student.unit"],
        ["name" => "Chapter", "url" => "student.chapter"],
    ];
    $cards = [
        ["title" => "roro", "url" => "student.week"],
        ["title" => "toto", "url" => "student.week"],
        ["title" => "toto", "url" => "student.week"]
    ]
@endphp

@section("insideContent")
    @include('components.path', ["paths" => $paths])
    @include('components.cards', ["cards" => $cards])
@endsection
