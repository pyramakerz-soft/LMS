@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1>Edit Role - {{ $role->name }}</h1>

                    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Role Name</label>
                            <input type="text" name="name" id="name" value="{{ $role->name }}"
                                class="w-full p-2 border border-gray-300 rounded" required>
                        </div>

                        <h4 class="font-semibold text-lg">Permissions:</h4>
                        <div class="mb-4 grid grid-cols-2 gap-2">
                            @foreach ($permissions as $permission)
                                <div>
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                        @if ($role->permissions->contains('name', $permission->name)) checked @endif>
                                    <label>{{ $permission->name }}</label>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Role</button>
                        <a href="{{ route('admin.roles.index') }}" class="text-blue-500 ml-4">Cancel</a>
                    </form>

                </div>
            </main>


        </div>
    </div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("typeform");

        form.addEventListener("submit", function() {
            const submitButton = form.querySelector("[type='submit']");
            submitButton.disabled = true; // Disable the button
            submitButton.innerHTML = "Submitting..."; // Optional: Change button text
        });
    });
</script>
