@extends('admin.layouts.layout')

@section('content')
<div class="wrapper">
    @include('admin.layouts.sidebar')

    <div class="main">
        @include('admin.layouts.navbar')

        <main class="content">
            <div class="container-fluid p-0">

                <h1>Add School and School Admin</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admins.store') }}" method="POST">
                    @csrf

                    <h2>School Information</h2>

                    <div class="mb-3">
                        <label for="school_name" class="form-label">School Name</label>
                        <input type="text" name="school_name" class="form-control" id="school_name" value="{{ old('school_name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label">Is Active</label>
                        <select name="is_active" id="is_active" class="form-control" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" id="address" value="{{ old('address') }}">
                    </div>

                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" name="city" class="form-control" id="city" value="{{ old('city') }}">
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="national">National</option>
                            <option value="international">International</option>
                        </select>
                    </div>

                    <h2>School Admin Information</h2>

                    <div class="mb-3">
                        <label for="admin_name" class="form-label">Admin Name</label>
                        <input type="text" name="admin_name" class="form-control" id="admin_name" value="{{ old('admin_name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="admin_email" class="form-label">Admin Email</label>
                        <input type="email" name="admin_email" class="form-control" id="admin_email" value="{{ old('admin_email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="admin_password" class="form-label">Password</label>
                        <input type="password" name="admin_password" class="form-control" id="admin_password" required>
                    </div>

                    <div class="mb-3">
                        <label for="admin_password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="admin_password_confirmation" class="form-control" id="admin_password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Add School and Admin</button>
                </form>

            </div>
        </main>

        @include('admin.layouts.footer')
    </div>
</div>
@endsection
