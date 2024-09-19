@extends('pages.student.student')

@section('title')
    Theme
@endsection


@php
    $paths = ["link 1", "link 2"];
    $cards = [
        ["title" => "roro"],
        ["title" => "toto"]
    ]
@endphp

@section("insideContent")
    @include('components.path', ["paths" => $paths])
    @include('components.cards', ["cards" => $cards])
@endsection
