@extends('layouts.app')

@section("title")
    @yield("title")
@endsection

@php
$menuItems = [
    ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => 'student.theme'],
    ['label' => 'Assignment', 'icon' => 'fas fa-home', 'route' => 'student.assignment'],
];
@endphp
@section("sidebar")
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection

@section("content")
<div class="p-5">
    @include('components.profile', ['name' => 'mennaosama' , 'subText'=>'class1' , "image" => "https://mdbcdn.b-cdn.net/img/new/avatars/9.webp"] )
    {{-- @yield("content") --}}
    @yield("InsideContent")
</div>

@endsection