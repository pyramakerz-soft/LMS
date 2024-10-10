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

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
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

                        <div class="mb-3">
    <label for="type" class="form-label">Type</label>
    <select name="type_id" id="type" class="form-control" required>
        <option value="" selected disabled>Select type</option>
        @if ($types && $types->isNotEmpty())
            @foreach ($types as $type)
                <option value="{{ $type->id }}" {{ $school->type_id == $type->id ? 'selected' : '' }}>
                    {{ $type->name }}
                </option>
            @endforeach
        @endif
    </select>
</div>

<!-- Grade Selection -->
<div class="mb-3">
    <label for="stage_ids" class="form-label">Grades</label>
    <select name="stage_id[]" id="stage_id" class="form-control" multiple required>
        @if ($stages && $stages->isNotEmpty())
            @foreach ($stages as $stage)
                <option value="{{ $stage->id }}"
                    {{ in_array($stage->id, $school->stages->pluck('id')->toArray()) ? 'selected' : '' }}>
                    {{ $stage->name }}
                </option>
            @endforeach
        @endif
    </select>
</div>

                        <!-- Classes -->
                        <div class="mt-3">
                            <h2>Classes</h2>
                            <div id="class-container">
                                @if ($school->groups && $school->groups->isNotEmpty())
                                @foreach ($school->groups as $group)
                                    <div class="class-group mb-3" id="class-group-{{ $group->id }}">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="class_name_{{ $group->id }}" class="form-label">Class Name</label>
                                                    <input type="text" name="classes[{{ $group->id }}][name]"
                                                        class="form-control"
                                                        value="{{ $group->name }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="class_stage_{{ $group->id }}" class="form-label">Grade</label>
                                                    <select name="classes[{{ $group->id }}][stage_id]"
                                                        class="form-control" required>
                                                        @foreach ($stages as $stage)
                                                            <option value="{{ $stage->id }}"
                                                                {{ $group->stage_id == $stage->id ? 'selected' : '' }}>
                                                                {{ $stage->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <button type="button" class="btn btn-danger remove-class-btn"
                                                    data-class-id="{{ $group->id }}">Remove Class</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @endif
                            </div>
                            <button type="button" class="btn btn-secondary" id="add-class-btn">Add Class</button>
                        </div>

                        <!-- Active -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1"
                                {{ $school->is_active ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">Active</label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Update School</button>
                    </form>

                </div>
            </main>

             
        </div>
    </div>
@endsection

@section('page_js')
   <script>
    document.addEventListener('DOMContentLoaded', function() {
        let classCount = {{ $school->groups ? $school->groups->count() : 0 }};
        
        const addClassBtn = document.getElementById('add-class-btn');
        const classContainer = document.getElementById('class-container');

        // Function to add a new class field group
        function addClassField() {
            classCount++;
            const classGroup = document.createElement('div');
            classGroup.classList.add('class-group', 'mb-3');
            classGroup.setAttribute('id', `class-group-${classCount}`);

            classGroup.innerHTML = `
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="class_name_${classCount}" class="form-label">Class Name</label>
                            <input type="text" name="classes[new_${classCount}][name]"
                                class="form-control" placeholder="Enter class name" required>
                        </div>

                        <div class="mb-3">
                            <label for="class_stage_${classCount}" class="form-label">Grade</label>
                            <select name="classes[new_${classCount}][stage_id]"
                                class="form-control" required>
                                @foreach ($stages as $stage)
                                    <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="button" class="btn btn-danger remove-class-btn" data-class-id="${classCount}">Remove Class</button>
                    </div>
                </div>
            `;

            classContainer.appendChild(classGroup);

            // Attach remove event to the newly added button
            classGroup.querySelector('.remove-class-btn').addEventListener('click', function() {
                const classId = this.getAttribute('data-class-id');
                document.getElementById(`class-group-${classId}`).remove();
            });
        }

        // Event listener to add a new class group
        addClassBtn.addEventListener('click', addClassField);
    });
</script>

@endsection
