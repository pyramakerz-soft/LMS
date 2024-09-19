{{-- @extends('layouts.app') --}}

{{-- @section('content') --}}
    <div class="container">
        <h2>Create Student</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('students.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select name="gender" id="gender" class="form-control" required>
                    <option value="boy">boy</option>
                    <option value="girl">girl</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="school_id" class="form-label">School</label>
                <select name="school_id" id="school_id" class="form-control" required>
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="stage_id" class="form-label">Stage</label>
                <select name="stage_id" id="stage_id" class="form-control" required>
                    @foreach ($stages as $stage)
                        <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Create Student</button>
        </form>
    </div>
{{-- @endsection --}}
