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
                            <label for="name" class="form-label">Schools Name</label>
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
                            <input id="city" type="text" name="city" class="form-control"
                                value="{{ $school->city }}">
                        </div>

                        <!-- Type -->
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select name="type_id" id="type" class="form-control">
                                <option value="" selected disabled>Select type</option>

                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}"
                                        {{ $school->type_id == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="stage_ids" class="form-label">Grades</label>
                            <select name="stage_id[]" id="stage_id" class="form-control" multiple required>
                                @foreach ($stages as $stage)
                                    <option value="{{ $stage->id }}"
                                        {{ in_array($stage->id, $school->stages->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $stage->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Active -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1"
                                {{ $school->is_active ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">Active</label>
                        </div>

                        <!-- Classes Section -->
                        <div class="mt-3">
                            <h2>Classes</h2>
                            <div id="class-container">
                                <!-- Existing classes will be loaded here -->
                                @foreach ($classes as $index => $class)
                                    <div class="card mb-3 class-group" id="class-group-{{ $index }}">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="class_name_{{ $loop->index }}" class="form-label">Class
                                                    Name</label>
                                                <input type="hidden" name="classes[{{ $loop->index }}][id]"
                                                    value="{{ $class->id }}">
                                                <input type="text" name="classes[{{ $loop->index }}][name]"
                                                    class="form-control"
                                                    value="{{ old('classes.' . $loop->index . '.name', $class->name) }}"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="class_stage_{{ $index }}"
                                                    class="form-label">Grade</label>
                                                <select name="classes[{{ $index }}][stage_id]" class="form-control"
                                                    id="class_stage_{{ $index }}" required>
                                                    @foreach ($stages as $stage)
                                                        <option value="{{ $stage->id }}"
                                                            {{ $class->stage_id == $stage->id ? 'selected' : '' }}>
                                                            {{ $stage->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <button type="button" class="btn btn-danger remove-class-btn"
                                                data-class-id="{{ $index }}">Remove Class</button>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <button type="button" class="btn btn-secondary" id="add-class-btn">Add Class</button>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary mt-5">Update School</button>
                    </form>

                </div>
            </main>
        </div>
    </div>
@endsection

@section('page_js')
    <script>
        $(document).ready(function() {
            $('#stage_id').select2({
                placeholder: "Select Grades",
                allowClear: true
            });

            const addClassBtn = document.getElementById('add-class-btn');
            const classContainer = document.getElementById('class-container');
            let classCount = 0;

            // Store original stage options for filtering
            const allStages = @json($stages).map(stage => ({
                id: stage.id,
                text: stage.name
            }));

            // Function to add a new class field group
            function addClassField(stages, classData = {}) {
                classCount++;
                const classGroup = document.createElement('div');
                classGroup.classList.add('class-group', 'mb-3');
                classGroup.setAttribute('id', `class-group-${classCount}`);

                // Generate stage options based on the selected stages
                let stageOptions = '';
                stages.forEach(stage => {
                    stageOptions +=
                        `<option value="${stage.id}" ${classData.stage_id == stage.id ? 'selected' : ''}>${stage.text}</option>`;
                });

                classGroup.innerHTML = `
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="class_name_${classCount}" class="form-label">Class Name</label>
                        <input type="text" name="classes[${classCount}][name]" class="form-control" id="class_name_${classCount}" placeholder="Enter class name" value="${classData.name || ''}" required>
                    </div>
                    <div class="mb-3">
                        <label for="class_stage_${classCount}" class="form-label">Grade</label>
                        <select name="classes[${classCount}][stage_id]" id="class_stage_${classCount}" class="form-control" required>
                            ${stageOptions}
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

            // Filter available stages based on the selected ones
            function getFilteredStages(selectedStages) {
                return allStages.filter(stage => selectedStages.includes(stage.id));
            }

            // Event listener for Grades selection change
            $('#stage_id').on('change', function() {
                const selectedStages = $(this).val().map(id => parseInt(id)); // Get selected stage IDs
                const filteredStages = getFilteredStages(selectedStages);

                // Enable Add Class button if stages are selected
                addClassBtn.disabled = filteredStages.length === 0;
            });

            // Event listener to add a new class group
            addClassBtn.addEventListener('click', function() {
                const selectedStages = $('#stage_id').val().map(id => parseInt(id));
                if (selectedStages.length > 0) {
                    const filteredStages = getFilteredStages(selectedStages);
                    addClassField(filteredStages);
                }
            });

            document.getElementById('city').addEventListener('input', function(event) {
                this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
            });

            // Load existing classes into the view
            const existingClasses = @json($classes);
            existingClasses.forEach((classData, index) => {
                const filteredStages = getFilteredStages([classData.stage_id]);
                addClassField(filteredStages, classData);
            });
        });
    </script>
@endsection
