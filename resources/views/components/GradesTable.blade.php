@extends('layouts.app')

@section('title')
    Teacher Dashboard
@endsection
@php

$menuItems = [
        ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')],
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
    <a href="{{ route('teacher_classes') }}" class="mx-2 cursor-pointer">Classes</a>
    <span class="mx-2 text-[#D0D5DD]">/</span>
    <a href="#" class="mx-2 cursor-pointer">Class Assessments</a>
</div>


<div class="">

    <div class="mt-5 overflow-x-auto rounded-2xl border border-[#EAECF0]">
        <table class="w-full table-auto bg-[#FFFFFF] text-[#475467] text-lg md:text-xl text-center">  
            <thead class="bg-[#F9FAFB]">  
                <tr>
                    <th class="py-4 px-6 min-w-[220px] whitespace-nowrap">Name</th>
                    <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">ATT</th>
                    <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">CP</th>
                    <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">CB</th>
                    <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">H.W</th>
                    <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Final Project</th>
                </tr>
            </thead>
            <tbody>
                @if(count($students) === 0)
                    <tr>
                        <td colspan="6" class="px-4 py-4 h-[72px] text-center border-t border-gray-300 text-lg md:text-xl">No Data Found</td>
                    </tr>
                @endif
                
                @foreach ($students as $student)
                    {{-- @dd($student->toArray(  )) --}}
                    @foreach($student as $s)
                    {{-- @dd($s->studentAssessment->pluck("attendance_score")->sum()); --}}
                    @php
                        $count = $s->studentAssessment->count();
                        $attendance_score = $s->studentAssessment->pluck("attendance_score")->sum();
                        $attendance_avg = $attendance_score / $count ; 
                        $cp_score = $s->studentAssessment->pluck("classroom_participation_score")->sum();
                        $cp_avg = $cp_score / $count ; 
                        $cb_score = $s->studentAssessment->pluck("classroom_behavior_score")->sum();
                        $cb_avg = $cb_score / $count ; 
                        $hw_score = $s->studentAssessment->pluck("homework_score")->sum();
                        $hw_avg = $hw_score / $count ; 
                    @endphp
                    <tr class="border-t border-gray-300 text-lg md:text-xl">    
                        <td class="py-5 px-6" rowspan="2">
                            <a href="{{ route('teacher.assessments.student' ,  $s->id) }}" class="text-blue-600 hover:underline">
                                {{ $s->username }}
                            </a>
                        </td>
                        {{-- <td class="py-5 px-6">
                            <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                <input class="w-[40px]" type="number"  value="{{ $s->pluck('attendance_score') ? $s->pluck('attendance_score') : 0 }}"> 
                                <p>/10 </p>
                            </div>
                        </td> --}}
                        <td class="py-5 px-6">
                            <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                <p class="mr-1">{{$attendance_avg ?? 0 }}</p>
                                <p>/20 </p>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                <p class="mr-1">{{$cp_avg ?? 0 }}</p>
                                <p>/20 </p>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                <p class="mr-1">{{ $cb_avg ?? 0 }}</p>
                                <p>/10 </p>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                <p class="mr-1">{{ $hw_avg ?? 0 }}</p>
                                <p>/50 </p>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-t border-gray-300 text-lg md:text-xl bg-[#DFE6FF]">
                        <td class="py-5 px-6">
                            <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                <input class="w-[40px] assessment-input" max="10" min="0" type="number" name="attendance_score" data-student-id="{{ $s->id }}" value="attendance_score"> 
                                <p>/10 </p>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                <input class="w-[40px] assessment-input" type="number" name="classroom_participation_score" data-student-id="{{ $s->id }}" value="classroom_participation_score"> 
                                <p>/20 </p>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                <input class="w-[40px] assessment-input" type="number" name="classroom_behavior_score" data-student-id="{{ $s->id }}" value="classroom_behavior_score"> 
                                <p>/20 </p>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                <input class="w-[40px] assessment-input" type="number" name="homework_score" data-student-id="{{ $s->id }}" value="homework_score"> 
                                <p>/10 </p>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                <input class="w-[40px] assessment-input" type="number" name="final_project_score" data-student-id="{{ $s->id }}" value="final_project_score"> 
                                <p>/50 </p>
                            </div>
                        </td> 
                    </tr>
                    

                    @if($loop->index != count($students) - 1)
                        <tr class="bg-white border border-x border-x-white">
                            <td colspan="6" class="p-0">
                                <div class="h-10 bg-transparent"></div>
                            </td>
                        </tr>
                    @endif
                    @endforeach
                @endforeach


            </tbody>
        </table>
    </div>

</div>

@endsection

@section('page_js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.assessment-input');
        inputs.forEach(input => {
            input.addEventListener('change', function() {
                const studentId = this.dataset.studentId;
                const fieldName = this.name;
                const value = this.value;
    
                const data = {
                    student_id: studentId,
                    [fieldName]: value,
                    week: 8 // You can dynamically pass the week or change it accordingly.
                };
    
                // Send AJAX request to save the assessment
                fetch("{{ route('teacher.storeAssessment') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // alert(data.message);
                    } else {
                        alert('Error saving the assessment');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
    
</script>
@endsection