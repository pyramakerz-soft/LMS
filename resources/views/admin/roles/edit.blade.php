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

                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-save"></i> Update Role
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- Assigned Permissions --}}
                            <div class="card mt-4 shadow-sm">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="mb-0">Assigned Permissions</h5>
                                </div>
                                <div class="card-body">
                                    @if ($role->permissions->isNotEmpty())
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($role->permissions as $role_permission)
                                                <form method="POST"
                                                    action="{{ route('roles.permissions.revoke', [$role->id, $role_permission->id]) }}"
                                                    onsubmit="return confirm('Are you sure you want to remove this permission?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-x-circle"></i> {{ $role_permission->name }}
                                                    </button>
                                                </form>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted">No permissions assigned to this role.</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Assign New Permission --}}
                            <div class="card mt-4 shadow-sm">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">Assign New Permission</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('roles.permissions', $role->id) }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="permission" class="form-label">Select Permission</label>
                                            <select id="permission" name="permission" class="form-select">
                                                @foreach ($permissions as $permission)
                                                    <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-plus-circle"></i> Assign Permission
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
@endsection
