@extends('pages.teacher.teacher')

@section('content')
    <div class="container">
        <h1>Assessments for {{ $student->username }}</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Attendance (Max 10)</th>
                    <th>Classroom Participation (Max 15)</th>
                    <th>Classroom Behavior (Max 15)</th>
                    <th>Homework (Max 10)</th>
                    <th>Final Project (Max 50)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assessments as $assessment)
                    <tr>
                        <td>{{ $assessment->created_at->format('Y-m-d') }}</td>
                        <td>{{ $assessment->attendance_score }} / 10</td>
                        <td>{{ $assessment->classroom_participation_score }} / 15</td>
                        <td>{{ $assessment->classroom_behavior_score }} / 15</td>
                        <td>{{ $assessment->homework_score }} / 10</td>
                        <td>{{ $assessment->final_project_score }} / 50</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No assessments found for this student.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <a href="{{ route('assessments.create') }}" class="btn btn-primary">Back to Assessments</a>
    </div>
@endsection
