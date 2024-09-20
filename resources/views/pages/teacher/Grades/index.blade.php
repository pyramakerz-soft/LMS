@extends('pages.teacher.teacher')

@section("title")
Theme
@endsection

@section("InsideContent")

@php

$tableDataa = [
    [
        'name' => 'John Doe',
        'records' => [
            ['attendance' => 'Present', 'participation' => 'Active', 'behavior' => 'Good', 'homework' => 'Completed', 'final_project' => 'A'],
            ['attendance' => 'Absent', 'participation' => 'N/A', 'behavior' => 'N/A', 'homework' => 'Incomplete', 'final_project' => 'B'],
        ]
    ],
];

$paths = [
        ["name" => "Theme", "url" => "student.theme"],
        ["name" => "Unit", "url" => "student.unit"],
        ["name" => "Chapter", "url" => "student.chapter"],
    ]; // Example of paths
@endphp


    @include('components.path',['paths' => $paths])

    @include('components.GradesTable', ['tableData' => $tableDataa])



@endsection

