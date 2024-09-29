@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">
                    <h1>Edit Student</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="username"
                                value="{{ $student->username }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" class="form-control" id="gender" required>
                                <option value="boy" {{ $student->gender == 'boy' ? 'selected' : '' }}>Boy</option>
                                <option value="girl" {{ $student->gender == 'girl' ? 'selected' : '' }}>Girl</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="school_id" class="form-label">School</label>
                            <select name="school_id" class="form-control" id="school_id" required>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}"
                                        {{ $student->school_id == $school->id ? 'selected' : '' }}>
                                        {{ $school->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="stage_id" class="form-label">Stage</label>
                            <select name="stage_id" class="form-control" id="stage_id" required>
                                @foreach ($stages as $stage)
                                    <option value="{{ $stage->id }}"
                                        {{ $student->stage_id == $stage->id ? 'selected' : '' }}>
                                        {{ $stage->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*">
                            @if ($student->image)
                                <p>Current Image: <img src="{{ asset( $student->image) }}" alt="Student Image"
                                        width="100"></p>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">Update Student</button>
                    </form>

                </div>
            </main>

            @include('admin.layouts.footer')
        </div>
    </div>
@endsection
