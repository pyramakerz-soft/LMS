@extends('layouts.app')

@section("title")
    @yield("title")
@endsection

@php
$menuItems = [
    ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => '#'],
    ['label' => 'Assignment', 'icon' => 'fas fa-home', 'route' => '#'],
];

@endphp
@section("sidebar")
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection

@section("content")
    <div class="p-5">
        @include('components.profile', ['name' => "Ahmed Mohamed", "subText" => "Grade: 1 - Class A1", "image" => "https://mdbcdn.b-cdn.net/img/new/avatars/9.webp"])
        @yield("insideContent")
    </div>
@endsection