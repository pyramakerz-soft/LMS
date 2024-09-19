@extends('layouts.app')

@section("title")
    @yield("title")
@endsection

@php
$menuItems = [
    ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => '#'],
];

@endphp
@section("sidebar")
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection

@section("content")
    @yield("content")
@endsection