
@extends('layouts.app')

@section('title')
    Teacher Dashboard
@endsection
@php

$menuItems = [
        ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')],
    ];


    $tableData = [
    [
        'records' => [
            [
                'attendance' => 9,
                'participation' => 18,
                'behavior' => 20,
                'homework' => 8,
                'final_project' => 45
            ],
            [
                'attendance' => 8,
                'participation' => 19,
                'behavior' => 17,
                'homework' => 9,
                'final_project' => 48
            ],
            [
                'attendance' => 8,
                'participation' => 19,
                'behavior' => 17,
                'homework' => 9,
                'final_project' => 48
            ],
            [
                'attendance' => 8,
                'participation' => 19,
                'behavior' => 17,
                'homework' => 9,
                'final_project' => 48
            ],
            [
                'attendance' => 8,
                'participation' => 19,
                'behavior' => 17,
                'homework' => 9,
                'final_project' => 48
            ],
            [
                'attendance' => 8,
                'participation' => 19,
                'behavior' => 17,
                'homework' => 9,
                'final_project' => 48
            ],
            [
                'attendance' => 8,
                'participation' => 19,
                'behavior' => 17,
                'homework' => 9,
                'final_project' => 48
            ],
            [
                'attendance' => 8,
                'participation' => 19,
                'behavior' => 17,
                'homework' => 9,
                'final_project' => 48
            ],
            [
                'attendance' => 8,
                'participation' => 19,
                'behavior' => 17,
                'homework' => 9,
                'final_project' => 48
            ],
        ],
    ]
];
@endphp

@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection

@section('content')

<div class="p-3">
    <div class="rounded-lg flex items-center justify-between py-3 px-6 bg-[#2E3646]">
        <div class="flex items-center space-x-4">
            <div>
                <img class="w-20 h-20 rounded-full" alt="avatar" src="{{ Auth::guard('teacher')->user()->image }}" />
            </div>

            <div class="ml-3 font-semibold text-white flex flex-col space-y-2">
                <div class="text-xl">
                    {{ Auth::guard('teacher')->user()->username }}
                </div>
                <div class="text-sm">
                    {{ Auth::guard('teacher')->user()->school->name }}
                </div>
            </div>
        </div>
    </div>
    @yield('insideContent')
</div>


<div class="p-3 text-[#667085] my-8">
    <i class="fa-solid fa-house mx-2"></i>
    <span class="mx-2 text-[#D0D5DD]">/</span>
    <a href="" class="mx-2 cursor-pointer">Assaasments</a>
    <span class="mx-2 text-[#D0D5DD]">/</span>
    <a href="" class="mx-2 cursor-pointer">Student name</a>
</div>


<div class="">

    <div class="mt-5 overflow-x-auto rounded-2xl border border-[#EAECF0]">
        <table class="w-full table-auto bg-[#FFFFFF] text-[#475467] text-lg md:text-xl text-center">  
            <thead class="bg-[#F9FAFB]">  
                <tr>
                    <th class="py-4 px-6 min-w-[220px] whitespace-nowrap">Name</th>
                    <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Attendance</th>
                    <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Classroom Participation</th>
                    <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Classroom Behavior</th>
                    <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Homework</th>
                    <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Final Project</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tableData as $student)
                    <tr class="{{ $loop->index % 2 === 0 ? 'bg-white' : 'bg-[#DFE6FF]' }}">
                        <td class="bg-white p-5" rowspan="{{ count($student['records']) }}">Rana Mohamed</td>
                        <td class="py-5 px-6">
                            <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                <input class="w-[40px]" type="number" value="{{ $student['records'][0]['attendance'] ? $student['records'][0]['attendance'] : 0 }}"> 
                                <p>/10 </p>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                <input class="w-[40px]" type="number" value="{{$student['records'][0]['participation'] ? $student['records'][0]['participation'] : 0 }}"> 
                                <p>/20 </p>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                <input class="w-[40px]" type="number" value="{{ $student['records'][0]['behavior']? $student['records'][0]['behavior']: 0 }}"> 
                                <p>/20 </p>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                <input class="w-[40px]" type="number" value="{{ $student['records'][0]['homework'] ? $student['records'][0]['homework'] : 0 }}"> 
                                <p>/10 </p>
                            </div>
                        </td>
                        <td class="py-5 px-6" rowspan="{{ count($student['records']) }}"> 
                            <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                <input class="w-[40px]" type="number" value="{{ $student['records'][0]['final_project'] ? $student['records'][0]['final_project'] : 0 }}"> 
                                <p>/50 </p>
                            </div>
                        </td>
                    </tr>
                       
                    @foreach (array_slice($student['records'], 1) as $record)
                        <tr class="border-t border-gray-300 text-lg md:text-xl {{ $loop->index % 2 === 0 ? 'bg-[#DFE6FF]' : 'bg-white' }}">
                            <td class="py-5 px-6">
                                <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                    <input class="w-[40px]" type="number" value="{{ $record['attendance'] ? $record['attendance'] : 0 }}"> 
                                    <p>/10 </p>
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                    <input class="w-[40px]" type="number" value="{{ $record['participation'] ? $record['participation'] : 0 }}"> 
                                    <p>/20 </p>
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                    <input class="w-[40px]" type="number" value="{{ $record['behavior'] ? $record['behavior'] : 0 }}"> 
                                    <p>/20 </p>
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                    <input class="w-[40px]" type="number" value="{{ $record['homework'] ? $record['homework'] : 0 }}"> 
                                    <p>/10 </p>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
