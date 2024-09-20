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
    [
        'name' => 'Jane Smith',
        'records' => [
            ['attendance' => 'Present', 'participation' => 'Average', 'behavior' => 'Excellent', 'homework' => 'Completed', 'final_project' => 'A+'],
        ]
    ]
];

$paths = [
        ["name" => "Theme", "url" => "student.theme"],
        ["name" => "Unit", "url" => "student.unit"],
        ["name" => "Chapter", "url" => "student.chapter"],
    ]; // Example of paths

@endphp

<div class="p-4">


    @include('components.path',['paths' => $paths])

    @include('components.GradesTable', ['tableData' => $tableDataa])

</div>


@endsection

