@php
    $userAuth = auth()->guard('teacher')->user();
@endphp

@extends('layouts.app')

@section('title')
    Students Assigned to {{ $assignment->title }}
@endsection

@php
    $menuItems = [['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')]];
@endphp
@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection
@section('content')
    <div class="p-3">
        <div class="rounded-lg flex items-center justify-between py-3 px-6 bg-[#2E3646]">
            <div class="flex items-center space-x-4">
                <h1 class="font-semibold text-2xl md:text-3xl text-white">Students Assigned to {{ $assignment->title }}</h1>
            </div>
        </div>

        <div class="p-3">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="overflow-x-auto rounded-2xl border border-[#EAECF0] mt-5">
                <table class="w-full table-auto bg-[#FFFFFF] text-left text-[#475467] text-lg md:text-xl">
                    <thead class="bg-[#F9FAFB] text-lg md:text-xl">
                        <tr>
                            <th class="py-4 px-6">Student Name</th>
                            <th class="py-4 px-6">Submission Status</th>
                            <th class="py-4 px-6">Submission Date</th>
                            <th class="py-4 px-6">File</th>
                            <th class="py-4 px-6">Marks</th>
                            <th class="py-4 px-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($students->isEmpty())
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center border-t border-gray-300">No Students
                                    Assigned</td>
                            </tr>
                        @else
                            @foreach ($students as $student)
                                <tr
                                    class="border-t border-gray-300 {{ $loop->index % 2 === 0 ? 'bg-[#F4F4F4]' : 'bg-white' }}">
                                    <td class="py-5 px-6">{{ $student->student_name }}</td>
                                    <td class="py-5 px-6">{{ $student->submitted_at ? 'Submitted' : 'Not Submitted' }}</td>
                                    <td class="py-5 px-6">{{ $student->submitted_at ?? 'N/A' }}</td>
                                    <td class="py-5 px-6">
                                        @if ($student->path_file)
                                            <a href="{{ asset($student->path_file) }}" class="text-blue-500"
                                                download>Download File</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="py-5 px-6">{{ $student->marks ?? 'Not Graded' }}</td>
                                    <td class="py-5 px-6">
                                        <form
                                            action="{{ route('assignments.students.update', [$assignment->id, $student->student_id]) }}"
                                            method="POST" style="display:inline-block;">
                                            @csrf
                                            <input type="number" name="marks" value="{{ $student->marks }}"
                                                class="border border-gray-300 rounded p-1 w-20">
                                            <button type="submit" class="btn btn-primary ml-2">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
