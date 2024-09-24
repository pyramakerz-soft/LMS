@extends('pages.teacher.teacher')

@section('content')

<div class="container">
    <h1>Create Assessments for Students</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('assessments.store') }}" method="POST">
        @csrf

        @foreach($students as $student)
            <div class="card mb-3">
                <div class="card-header">
                    {{ $student->username }} ({{ $student->school->name }}, {{ $student->stage->name }})
                </div>
                <div class="card-body">
                    <input type="hidden" name="assessments[{{ $loop->index }}][student_id]" value="{{ $student->id }}">
                    
                    <div class="mb-3">
                        <label for="attendance_score_{{ $student->id }}" class="form-label">Attendance Score (Max 10)</label>
                        <input type="number" name="assessments[{{ $loop->index }}][attendance_score]" id="attendance_score_{{ $student->id }}" class="form-control" max="10">
                    </div>

                    <div class="mb-3">
                        <label for="classroom_participation_score_{{ $student->id }}" class="form-label">Classroom Participation Score (Max 15)</label>
                        <input type="number" name="assessments[{{ $loop->index }}][classroom_participation_score]" id="classroom_participation_score_{{ $student->id }}" class="form-control" max="15">
                    </div>

                    <div class="mb-3">
                        <label for="classroom_behavior_score_{{ $student->id }}" class="form-label">Classroom Behavior Score (Max 15)</label>
                        <input type="number" name="assessments[{{ $loop->index }}][classroom_behavior_score]" id="classroom_behavior_score_{{ $student->id }}" class="form-control" max="15">
                    </div>

                    <div class="mb-3">
                        <label for="homework_score_{{ $student->id }}" class="form-label">Homework Score (Max 10)</label>
                        <input type="number" name="assessments[{{ $loop->index }}][homework_score]" id="homework_score_{{ $student->id }}" class="form-control" max="10">
                    </div>

                    <div class="mb-3">
                        <label for="final_project_score_{{ $student->id }}" class="form-label">Final Project Score (Max 50)</label>
                        <input type="number" name="assessments[{{ $loop->index }}][final_project_score]" id="final_project_score_{{ $student->id }}" class="form-control" max="50">
                    </div>
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Submit Assessments</button>
    </form>
</div>

@endsection
