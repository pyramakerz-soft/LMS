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
    ["name" => "Assignments", "url" => "teacher.assignments_cards"],
    ["name" => "class number", "url" => "teacher.class"],
    ["name" => "student name", "url" => "teacher.student.grade"],

    ]; // Example of paths
@endphp


    @include('components.path',['paths' => $paths])

    @include('components.GradesTable', ['tableData' => $tableDataa])



@endsection

