@extends('pages.teacher.teacher')

@section('title')
    Theme
@endsection


@php
    $paths = [
        ["name" => "Assignments", "url" => "teacher.assignments_cards"]
    ];
    $cards = [
        ["title" => "g1", "url" => "teacher.class"],
        ["title" => "g1", "url" => "teacher.class"],
        ["title" => "g1", "url" => "teacher.class"],
        ["title" => "g1", "url" => "teacher.class"],
        ["title" => "g1", "url" => "teacher.class"],
        ["title" => "g1", "url" => "teacher.class"],
        ["title" => "g1", "url" => "teacher.class"]
    ]
@endphp

@section("InsideContent")
    @include('components.path', ["paths" => $paths])
    @include('components.cards', ["cards" => $cards])
@endsection
