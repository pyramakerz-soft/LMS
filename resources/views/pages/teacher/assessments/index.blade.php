@extends('pages.teacher.teacher')

@section('content')
    <div class="container">
        <h1>Student Assessments</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Attendance (Max 10)</th>
                    <th>Classroom Participation (Max 15)</th>
                    <th>Classroom Behavior (Max 15)</th>
                    <th>Homework (Max 10)</th>
                    <th>Final Project (Max 50)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>
                            <!-- Make the student's name a clickable link -->
                            <a href="{{ route('teacher.assessments.student', $student->id) }}">
                                {{ $student->username }}
                            </a>
                        </td>
                        @php
                            // Get the latest assessment for this student
                            $assessment = $student->studentAssessment->first(); // Get the first assessment (latest) for this student
                        @endphp
                        <td>{{ $assessment->attendance_score ?? '--' }} / 10</td>
                        <td>{{ $assessment->classroom_participation_score ?? '--' }} / 15</td>
                        <td>{{ $assessment->classroom_behavior_score ?? '--' }} / 15</td>
                        <td>{{ $assessment->homework_score ?? '--' }} / 10</td>
                        <td>{{ $assessment->final_project_score ?? '--' }} / 50</td>
                        <td>
                            <a href="{{ route('teacher.assessments.student', $student->id) }}" class="btn btn-info">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
