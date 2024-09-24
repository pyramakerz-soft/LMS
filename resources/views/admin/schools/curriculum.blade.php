@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1>Assign Curriculum to {{ $school->name }}</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">{{ implode('', $errors->all(':message')) }}</div>
                    @endif

                    <form action="{{ route('school.curriculum.store', $school->id) }}" method="POST">
                        @csrf

                        <!-- Stage Selection -->
                        <div class="mb-3">
                            <label for="stage_id" class="form-label">Select Stage</label>
                            <select name="stage_id" id="stage_id" class="form-control">
                                <option value="">-- Select Stage --</option>
                                @foreach ($stages as $stage)
                                    <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Material Selection -->
                        <div class="mb-3">
                            <label for="material_id" class="form-label">Select Material</label>
                            <select name="material_id" id="material_id" class="form-control" disabled>
                                <option value="">-- Select Material --</option>
                            </select>
                        </div>

                        <!-- Unit Selection -->
                        <div class="mb-3">
                            <label for="unit_id" class="form-label">Select Unit</label>
                            <select name="unit_id" id="unit_id" class="form-control" disabled>
                                <option value="">-- Select Unit --</option>
                            </select>
                        </div>

                        <!-- Chapter Selection -->
                        <div class="mb-3">
                            <label for="chapter_id" class="form-label">Select Chapter</label>
                            <select name="chapter_id" id="chapter_id" class="form-control" disabled>
                                <option value="">-- Select Chapter --</option>
                            </select>
                        </div>

                        <!-- Lesson Selection -->
                        <div class="mb-3">
                            <label for="lesson_id" class="form-label">Select Lesson</label>
                            <select name="lesson_id" id="lesson_id" class="form-control" disabled>
                                <option value="">-- Select Lesson --</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Assign Curriculum</button>
                    </form>

                </div>
            </main>

            @include('admin.layouts.footer')
        </div>
    </div>
@endsection

@section('page_js')

    <script>
        document.getElementById('stage_id').addEventListener('change', function() {
            let stageId = this.value;
            if (stageId) {
                fetch(`/api/stages/${stageId}/materials`)
                    .then(response => response.json())
                    .then(data => {
                        let materialSelect = document.getElementById('material_id');
                        materialSelect.innerHTML = '<option value="">-- Select Material --</option>';
                        data.forEach(material => {
                            materialSelect.innerHTML +=
                                `<option value="${material.id}">${material.title}</option>`;
                        });
                        materialSelect.disabled = false;
                    });
            } else {
                document.getElementById('material_id').disabled = true;
            }
        });

        document.getElementById('material_id').addEventListener('change', function() {
            let materialId = this.value;
            if (materialId) {
                fetch(`/api/materials/${materialId}/units`)
                    .then(response => response.json())
                    .then(data => {
                        let unitSelect = document.getElementById('unit_id');
                        unitSelect.innerHTML = '<option value="">-- Select Unit --</option>';
                        data.forEach(unit => {
                            unitSelect.innerHTML += `<option value="${unit.id}">${unit.title}</option>`;
                        });
                        unitSelect.disabled = false;
                    });
            } else {
                document.getElementById('unit_id').disabled = true;
            }
        });

        document.getElementById('unit_id').addEventListener('change', function() {
            let unitId = this.value;
            if (unitId) {
                fetch(`/api/units/${unitId}/chapters`)
                    .then(response => response.json())
                    .then(data => {
                        let chapterSelect = document.getElementById('chapter_id');
                        chapterSelect.innerHTML = '<option value="">-- Select Chapter --</option>';
                        data.forEach(chapter => {
                            chapterSelect.innerHTML +=
                                `<option value="${chapter.id}">${chapter.title}</option>`;
                        });
                        chapterSelect.disabled = false;
                    });
            } else {
                document.getElementById('chapter_id').disabled = true;
            }
        });

        document.getElementById('chapter_id').addEventListener('change', function() {
            let chapterId = this.value;
            if (chapterId) {
                fetch(`/api/chapters/${chapterId}/lessons`)
                    .then(response => response.json())
                    .then(data => {
                        let lessonSelect = document.getElementById('lesson_id');
                        lessonSelect.innerHTML = '<option value="">-- Select Lesson --</option>';
                        data.forEach(lesson => {
                            lessonSelect.innerHTML +=
                                `<option value="${lesson.id}">${lesson.title}</option>`;
                        });
                        lessonSelect.disabled = false;
                    });
            } else {
                document.getElementById('lesson_id').disabled = true;
            }
        });
    </script>
@endsection
