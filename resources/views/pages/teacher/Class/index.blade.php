@extends('pages.teacher.teacher')

@section("title")
    Class
@endsection

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
        ["name" => "Grade", "url" => "teacher.theme"],
        ["name" => "Material", "url" => "teacher.material"],
        ["name" => "Theme", "url" => "teacher.theme"],
        ["name" => "Unit", "url" => "teacher.unit"],
        ["name" => "Chapter", "url" => "teacher.chapter"],
        ["name" => "Lesson", "url" => "teacher.lesson"],
        ["name" => "Assignments", "url" => "teacher.assignments_cards"],
        ["name" => "Class number", "url" => "teacher.class"]
    ];
@endphp

@section("InsideContent")
    <div>
        @include('components.path',['paths' => $paths])

        @include('components.GradesTable', ['tableData' => $tableDataa])

    </div>
@endsection

