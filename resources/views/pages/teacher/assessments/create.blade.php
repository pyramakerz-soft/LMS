@extends('pages.teacher.teacher')

@section('content')
    <div class="container">
        <h1>Create Assessment</h1>

        <form action="{{ route('assessments.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="student_id" class="form-label">Select Student</label>
                <select name="student_id" id="student_id" class="form-control" required>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}">{{ $student->username }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="attendance_score" class="form-label">Attendance Score</label>
                <input type="number" name="attendance_score" class="form-control" id="attendance_score"
                    value="{{ old('attendance_score') }}" max="10">
            </div>

            <div class="mb-3">
                <label for="classroom_participation_score" class="form-label">Classroom Participation Score</label>
                <input type="number" name="classroom_participation_score" class="form-control"
                    id="classroom_participation_score" value="{{ old('classroom_participation_score') }}" max="15">
            </div>

            <div class="mb-3">
                <label for="classroom_behavior_score" class="form-label">Classroom Behavior Score</label>
                <input type="number" name="classroom_behavior_score" class="form-control" id="classroom_behavior_score"
                    value="{{ old('classroom_behavior_score') }}" max="15">
            </div>

            <div class="mb-3">
                <label for="homework_score" class="form-label">Homework Score</label>
                <input type="number" name="homework_score" class="form-control" id="homework_score"
                    value="{{ old('homework_score') }}" max="10">
            </div>

            <div class="mb-3">
                <label for="final_project_score" class="form-label">Final Project Score</label>
                <input type="number" name="final_project_score" class="form-control" id="final_project_score"
                    value="{{ old('final_project_score') }}" max="50">
            </div>

            <button type="submit" class="btn btn-primary">Create Assessment</button>
        </form>
    </div>
@endsection
