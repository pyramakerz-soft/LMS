@extends('pages.teacher.teacher')

@section('content')
    <div class="container">
        <h1>Student Assessments</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('assessments.create') }}" class="btn btn-primary mb-3">Add Assessment</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Attendance</th>
                    <th>Classroom Participation</th>
                    <th>Classroom Behavior</th>
                    <th>Homework</th>
                    <th>Final Project</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    @if ($student->studentAssessments && $student->studentAssessments->isNotEmpty())
                        <!-- Check if student has assessments -->
                        @foreach ($student->studentAssessments as $assessment)
                            <tr>
                                <td>{{ $student->username }}</td>
                                <td>{{ $assessment->attendance_score ?? '--' }} / 10</td>
                                <td>{{ $assessment->classroom_participation_score ?? '--' }} / 15</td>
                                <td>{{ $assessment->classroom_behavior_score ?? '--' }} / 15</td>
                                <td>{{ $assessment->homework_score ?? '--' }} / 10</td>
                                <td>{{ $assessment->final_project_score ?? '--' }} / 50</td>
                                <td>
                                    <a href="{{ route('teacher.assessments.edit', $assessment->id) }}"
                                        class="btn btn-info">Edit</a>
                                    <form action="{{ route('teacher.assessments.destroy', $assessment->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>{{ $student->username }}</td>
                            <td colspan="6">No assessments available</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
