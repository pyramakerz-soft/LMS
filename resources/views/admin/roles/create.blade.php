@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1>Create Role</h1>
                    <form action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf
                        <input type="text" name="name" placeholder="Role Name" required>
                        <h4>Permissions:</h4>
                        @foreach ($permissions as $permission)
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                            {{ $permission->name }}<br>
                        @endforeach
                        <button type="submit" class="btn btn-success">Create Role</button>
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
