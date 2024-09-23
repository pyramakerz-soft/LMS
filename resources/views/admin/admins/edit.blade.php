@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1>Edit School</h1>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('admins.update', $school->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- School Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">School Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $school->name }}" required>
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ $school->address }}">
                        </div>

                        <!-- City -->
                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" name="city" class="form-control" value="{{ $school->city }}">
                        </div>

                        <!-- Type -->
                        <div class="mb-3">
                            <label for="type" class="form-label">School Type</label>
                            <select name="type" class="form-control" required>
                                <option value="international" {{ $school->type == 'international' ? 'selected' : '' }}>
                                    International</option>
                                <option value="national" {{ $school->type == 'national' ? 'selected' : '' }}>National
                                </option>
                            </select>
                        </div>

                        <!-- Is Active -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1"
                                {{ $school->is_active ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">Is Active</label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Update School</button>
                    </form>

                </div>
            </main>

            @include('admin.layouts.footer')
        </div>
    </div>
@endsection
