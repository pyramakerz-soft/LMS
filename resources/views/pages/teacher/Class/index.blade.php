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

<div class="p-4">
    @include('components.profile', ['name' => 'menna' , 'subText'=>'class1' , "image" => "https://mdbcdn.b-cdn.net/img/new/avatars/9.webp"] )


    @include('components.path',['paths' => ['Assignment','Class1']])

    @include('components.GradesTable', ['tableData' => $tableDataa])

</div>


@endsection
