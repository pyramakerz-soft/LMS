{{-- @extends('layouts.app')

@section('content') --}}
<div class="container">
    <h2>Students</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Username</th>
                <th>Password</th> 
                <th>School</th>
                <th>Stage</th>
                <th>Gender</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->username }}</td>
                    <td>{{ $student->plain_password }}</td> 
                    <td>{{ $student->school->name }}</td>
                    <td>{{ $student->stage->name }}</td>
                    <td>{{ $student->gender }}</td>
                    <td>{{ $student->status }}</td>
                    <td>{{ $student->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{-- @endsection --}}
