@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">
                    <h1>Students</h1>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @can('create student')
                        <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">Add Student</a>
                    @endcan
                    <form id="filterForm" action="{{ route('students.index') }}" method="GET"
                        class="d-flex justify-content-evenly mb-3">

                        <input type="text" name="search" class="form-control w-25" placeholder="Search by username"
                            value="{{ request('search') }}">
                        <select name="school" id="school" class="form-select w-25">
                            <option disabled selected hidden>Filter By School</option>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}"
                                    {{ request('school') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                            @endforeach
                        </select>
                        <select name="class" id="class" class="form-select w-25">
                            <option disabled selected hidden>Filter By Class</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">Search</button>

                        <a class="btn btn-secondary" href="{{ route('students.index') }}">Clear</a>
                    </form>

                    <form id="deleteMultipleForm" action="{{ route('students.deleteMultiple') }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all"></th> <!-- Master Checkbox -->
                                        <th>Image</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Gender</th>
                                        <th>School</th>
                                        <th>Stage</th>
                                        <th>Class</th>
                                        <th>#Logins</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <td><input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                                    class="select-student"></td>
                                            <td>
                                                @if ($student->image)
                                                    <img src="{{ asset($student->image) }}" alt="Student Image"
                                                        width="50" height="50" class="rounded-circle">
                                                @else
                                                    <img src="https://w7.pngwing.com/pngs/184/113/png-transparent-user-profile-computer-icons-profile-heroes-black-silhouette-thumbnail.png"
                                                        alt="Teacher Image" width="50" height="50"
                                                        class="rounded-circle">
                                                @endif
                                            </td>
                                            <td>{{ $student->username ?? '' }}</td>
                                            <td>{{ $student->plain_password }}</td>
                                            <td>{{ ucfirst($student->gender) }}</td>
                                            <td>{{ $student->school->name ?? '' }}</td>
                                            <td>{{ $student->stage->name ?? '' }}</td>
                                            <td>{{ $student->classes->name ?? '' }}</td>
                                            <td>{{ $student->num_logins }}</td>
                                            <td class="d-flex align-items-center gap-2">
                                                @can('update student')
                                                    <a href="{{ route('students.edit', $student->id) }}"
                                                        class="btn btn-info">Edit</a>
                                                @endcan
                                                @can('delete student')
                                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                                                        style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this student?');">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Delete Selected Button -->
                        @can('delete student')
                            <button type="submit" id="delete-selected" class="btn btn-danger mt-3" disabled>
                                Delete Selected
                            </button>
                        @endcan
                    </form>


                </div>
                {{-- {{ $students->links('pagination::bootstrap-5') }} --}}
                {{ $students->appends(request()->input())->links('pagination::bootstrap-5') }}

            </main>

        </div>
    </div>
@endsection

@section('page_js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#school, #class').change(function() {
                $('#filterForm').submit();
            });
        });

        $('#clearFilters').click(function(e) {
            e.preventDefault();
            $('#school').val('').prop('selected', true);
            $('#class').val('').prop('selected', true);
            $('#filterForm').submit();
        });
    </script>
    <script>
        $(document).ready(function() {
            // Handle the "Select All" checkbox
            $('#select-all').click(function() {
                $('.select-student').prop('checked', this.checked);
                toggleDeleteButton();
            });

            // Handle individual checkboxes
            $('.select-student').change(function() {
                if ($('.select-student:checked').length === $('.select-student').length) {
                    $('#select-all').prop('checked', true);
                } else {
                    $('#select-all').prop('checked', false);
                }
                toggleDeleteButton();
            });

            // Enable or disable delete button
            function toggleDeleteButton() {
                if ($('.select-student:checked').length > 0) {
                    $('#delete-selected').prop('disabled', false);
                } else {
                    $('#delete-selected').prop('disabled', true);
                }
            }
        });
    </script>
@endsection
