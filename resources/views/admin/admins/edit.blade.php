@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1>Edit School Admin</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admins.update', $admin->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="admin_name" class="form-label">Admin Name</label>
                            <input type="text" name="admin_name" class="form-control" id="admin_name"
                                value="{{ old('admin_name', $admin->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="admin_email" class="form-label">Admin Email</label>
                            <input type="email" name="admin_email" class="form-control" id="admin_email"
                                value="{{ old('admin_email', $admin->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="admin_password" class="form-label">Password (Leave empty if not changing)</label>
                            <input type="password" name="admin_password" class="form-control" id="admin_password">
                        </div>

                        <div class="mb-3">
                            <label for="admin_password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="admin_password_confirmation" class="form-control"
                                id="admin_password_confirmation">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Admin</button>
                    </form>

                </div>
            </main>

            @include('admin.layouts.footer')
        </div>
    </div>
@endsection
