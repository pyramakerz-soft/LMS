@extends('admin.layouts.layout')

@section('title', 'Edit Role')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container py-4">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card shadow-sm">
                                <div
                                    class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                                    <h5 class="text-light">Edit Role</h5>
                                    <a href="{{ route('admin.roles.index') }}" class="btn btn-light btn-sm">
                                        <i class="bi bi-arrow-left"></i> Back to Roles
                                    </a>
                                </div>

                                <div class="card-body">
                                    {{-- Role Edit Form --}}
                                    <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Role Name</label>
                                            <input type="text" id="name" name="name" value="{{ $role->name }}"
                                                class="form-control @error('name') is-invalid @enderror">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="permission" class="form-label">Select Permissions</label>
                                            <select id="permission" name="permissions[]" class="form-select select2"
                                                multiple>
                                                @foreach ($permissions as $permission)
                                                    <option value="{{ $permission->id }}"
                                                        @if ($role->permissions->contains($permission->id)) selected @endif>
                                                        {{ $permission->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-save"></i> Update Role
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    {{-- Include Select2 JS --}}
@section('page_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select Permissions",
                allowClear: true
            });
        });
    </script>
@endsection
@endsection
