@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container mt-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><i class="bi bi-person-circle"></i> User Details</h4>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> {{ $user->name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                        </div>
                    </div>

                    <!-- Roles Section -->
                    <div class="card shadow-sm border-0 mt-3">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-person-badge"></i> Assigned Roles</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($user->roles as $user_role)
                                    <button class="btn btn-danger btn-sm remove-role" data-user="{{ $user->id }}"
                                        data-role="{{ $user_role->id }}">
                                        <i class="bi bi-trash"></i> {{ $user_role->name }}
                                    </button>
                                @endforeach
                            </div>

                            <!-- Assign Role Form -->
                            <form method="POST" action="{{ route('users.roles', $user->id) }}" class="mt-3">
                                @csrf
                                <div class="row g-2">
                                    <div class="col-md-8">
                                        <select name="role" class="form-select">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="bi bi-plus-circle"></i> Assign Role
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Permissions Section -->
                    {{-- <div class="card shadow-sm border-0 mt-3">
                        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-key"></i> Assigned Permissions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($user->permissions as $user_permission)
                                    <button class="btn btn-danger btn-sm remove-permission" data-user="{{ $user->id }}"
                                        data-permission="{{ $user_permission->id }}">
                                        <i class="bi bi-trash"></i> {{ $user_permission->name }}
                                    </button>
                                @endforeach
                            </div>

                            <!-- Assign Permission Form -->
                            <form method="POST" action="{{ route('users.permissions', $user->id) }}" class="mt-3">
                                @csrf
                                <div class="row g-2">
                                    <div class="col-md-8">
                                        <select name="permission" class="form-select">
                                            @foreach ($permissions as $permission)
                                                <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="bi bi-plus-circle"></i> Assign Permission
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> --}}
                </div>
            </main>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove this role/permission?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let deleteForm = document.getElementById('deleteForm');
            let confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));

            document.querySelectorAll('.remove-role').forEach(button => {
                button.addEventListener('click', function() {
                    let userId = this.getAttribute('data-user');
                    let roleId = this.getAttribute('data-role');
                    deleteForm.setAttribute('action', `/users/${userId}/roles/${roleId}/remove`);
                    confirmModal.show();
                });
            });

            document.querySelectorAll('.remove-permission').forEach(button => {
                button.addEventListener('click', function() {
                    let userId = this.getAttribute('data-user');
                    let permissionId = this.getAttribute('data-permission');
                    deleteForm.setAttribute('action',
                        `/users/${userId}/permissions/${permissionId}/revoke`);
                    confirmModal.show();
                });
            });
        });
    </script>
@endsection
