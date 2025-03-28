@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h2>Create Type</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('types.store') }}" id="typeform" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <input type="text" name="name" id="type" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Type</button>
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
