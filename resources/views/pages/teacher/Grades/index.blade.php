@extends('pages.student.student')

@section("title")
Theme
@endsection

@section("content")

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
@endphp


@include('components.GradesTable', ['tableData' => $tableDataa])
@endsection

