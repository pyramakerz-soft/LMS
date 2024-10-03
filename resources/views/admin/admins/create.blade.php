@extends('admin.layouts.layout')

@section('content')
<div class="wrapper">
    @include('admin.layouts.sidebar')

    <div class="main">
        @include('admin.layouts.navbar')

        <main class="content">
            <div class="container-fluid p-0">

                <h1>Add School </h1>

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
                        <input type="text" name="name" class="form-control" id="school_name" value="{{ old('school_name') }}" required>
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

                     <!-- Stage Selection -->
                    <div class="mb-3">
                            <label for="stage_id" class="form-label">Grade</label>
                            <select name="stage_id" id="stage_id" class="form-control" required>
                                <option value="">Select Grade</option>
                                @foreach ($stages as $stage)
                                <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                               @endforeach
                            </select>
                    </div>
{{-- 
                    <form action="{{ route('classes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>


                        <div class="mb-3">
                            <label for="school_id" class="form-label">School</label>
                            <select name="school_id" id="school_id" class="form-control" required>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="stage_id" class="form-label">Grade</label>
                            <select name="stage_id" id="stage_id" class="form-control" required>
                                @foreach ($stages as $stage)
                                    <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                                @endforeach
                            </select>
                        </div>



                        <button type="submit" class="btn btn-primary">Create Class</button>
                    </form>
 --}}


                    <!-- Theme Selection -->
                    <div class="mb-3">
                        <label for="class_id" class="form-label">Theme</label>
                        <select name="class_id" id="class_id" class="form-control" required>
                            <option value="">Select Theme</option>
                            @foreach ($themes as $theme)
                            <option value="{{ $theme->id }}">{{ $theme->title }}</option>
                            @endforeach
                        </select>
                </div>

                    

                    <button type="submit" class="btn btn-primary">Add School </button>
                </form>

            </div>
        </main>

        @include('admin.layouts.footer')
    </div>
</div>
@endsection
