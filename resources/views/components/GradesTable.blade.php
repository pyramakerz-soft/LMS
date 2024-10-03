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
        'name' => 'John Doe',
        'records' => [
            [
                'attendance' => 8,
                'participation' => 15,
                'behavior' => 18,
                'homework' => 9,
                'final_project' => 45
            ]
        ]
    ],
    [
        'name' => 'Jane Smith',
        'records' => [
            [
                'attendance' => 9,
                'participation' => 17,
                'behavior' => 16,
                'homework' => 10,
                'final_project' => 47
            ]
        ]
    ],
    [
        'name' => 'Alex Johnson',
        'records' => [
            [
                'attendance' => 7,
                'participation' => 12,
                'behavior' => 19,
                'homework' => 8,
                'final_project' => 42
            ]
        ]
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
    <a href="" class="mx-2 cursor-pointer">class name</a>
</div>



<div class="">

    <div class="mt-5 overflow-x-auto rounded-2xl border border-[#EAECF0]">
        <table class="w-full table-auto bg-[#FFFFFF] text-left text-[#475467] text-lg md:text-xl">  
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
                @if(count($tableData) === 0)
                    <tr>
                        <td colspan="6" class="px-4 py-4 h-[72px] text-center border-t border-gray-300 text-lg md:text-xl">No Data Found</td>
                    </tr>
                @endif
                
                @foreach ($tableData as $student)
                    
                    @foreach ($student['records'] as $record)
                        <tr class="border-t border-gray-300 text-lg md:text-xl">    
                            <td class="py-5 px-6" rowspan="2">
                                <a href="{{ route('teacher.student.grade') }}" class="text-blue-600 hover:underline">
                                    {{ $student['name'] }}
                                </a>
                            </td>
                            <td class="py-5 px-6">
                                <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                    <input class="w-[40px]" type="number" value="{{ $record['attendance'] ? $record['attendance'] : 0 }}"> 
                                    <p>/10 </p>
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                    <input class="w-[40px]" type="number" value="{{$record['participation'] ? $record['participation'] : 0 }}"> 
                                    <p>/20 </p>
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                    <input class="w-[40px]" type="number" value="{{ $record['behavior']? $record['behavior']: 0 }}"> 
                                    <p>/20 </p>
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                    <input class="w-[40px]" type="number" value="{{ $record['homework'] ? $record['homework'] : 0 }}"> 
                                    <p>/10 </p>
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                    <input class="w-[40px]" type="number" value="{{ $record['final_project'] ? $record['final_project'] : 0 }}"> 
                                    <p>/50 </p>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="border-t border-gray-300 text-lg md:text-xl bg-[#DFE6FF]">
                        <td class="py-5 px-6">
                            <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                <input class="w-[40px]" type="number"> 
                                <p>/10 </p>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                <input class="w-[40px]" type="number"> 
                                <p>/20 </p>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                <input class="w-[40px]" type="number"> 
                                <p>/20 </p>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                <input class="w-[40px]" type="number"> 
                                <p>/10 </p>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                <input class="w-[40px]" type="number"> 
                                <p>/50 </p>
                            </div>
                        </td>
                    </tr>

                    @if($loop->index != count($tableData) - 1)
                        <tr class="bg-white border border-x border-x-white">
                            <td colspan="6" class="p-0">
                                <div class="h-10 bg-transparent"></div>
                            </td>
                        </tr>
                    @endif
                @endforeach


            </tbody>
        </table>
    </div>

</div>

@endsection
