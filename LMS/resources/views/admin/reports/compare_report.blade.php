@extends('admin.layouts.layout')

@section('content')
<div class="wrapper">
    @include('admin.layouts.sidebar')

    <div class="main">
        @include('admin.layouts.navbar')

        <main class="content">
            <div class="container-fluid p-0">
                <h2>Compare Assignment Average Degree Report</h2>

                @if (session('error'))
                <div class="alert alert-danger d-flex justify-content-between align-items-center" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>


                @endif

                <form id="compare-form" action="{{ route('admin.compareReport') }}" method="GET" enctype="multipart/form-data" class="mb-4 flex flex-column" style="gap:10px; padding:10px">
                    <!-- Compare By Field -->
                    <div class="mb-3">
                        <label for="compare_by">Compare By</label>
                        <select id="compare_by" name="compare_by" class="form-control" required>
                            <option value="" disabled>Select Option</option>
                            <option value="teachers" {{ request('compare_by') == 'teachers' ? 'selected' : '' }}>Teachers</option>
                            <option value="schools" {{ request('compare_by') == 'schools' ? 'selected' : '' }}>Schools</option>
                            <option value="classes" {{ request('compare_by') == 'classes' ? 'selected' : '' }}>Classes</option>
                        </select>
                    </div>

                    <!-- Teacher Comparison Fields -->
                    <div id="teacher-fields" class="comparison-fields mb-3" style="display: none;">
                        <label for="teacher_id">First Teacher</label>
                        <select name="teacher_id" id="teacher_select" class="form-control mb-3">
                            <option value="" selected disabled>Select Teacher</option>
                            @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}"
                                {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->username }}
                            </option>
                            @endforeach
                        </select>
                        <label for="teacher_id2">Second Teacher</label>
                        <select name="teacher_id2" id="teacher_select2" class="form-control">
                            <option value="" selected disabled>Select Teacher</option>
                            @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}"
                                {{ request('teacher_id2') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->username }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- School Comparison Fields -->
                    <div id="school-fields" class="comparison-fields mb-3" style="display: none;">
                        <label for="school_id">First School</label>
                        <select name="school_id" id="school_id" class="form-control mb-3">
                            <option value="" selected disabled>Select School</option>
                            @foreach ($schools as $school)
                            <option value="{{ $school->id }}"
                                {{ request('school_id') == $school->id ? 'selected' : '' }}>
                                {{ $school->name }}
                            </option>
                            @endforeach
                        </select>
                        <label for="school_id2">Second School</label>
                        <select name="school_id2" id="school_id2" class="form-control">
                            <option value="" selected disabled>Select School</option>
                            @foreach ($schools as $school)
                            <option value="{{ $school->id }}"
                                {{ request('school_id2') == $school->id ? 'selected' : '' }}>
                                {{ $school->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Class Comparison Fields -->
                    <div id="class-fields" class="comparison-fields mb-3" style="display: none;">
                        <label for="class_id">First Class</label>
                        <select name="class_id" id="class_id" class="form-control mb-3">
                            <option value="" selected disabled>Select Class</option>
                            @foreach ($classes as $class)
                            <option value="{{ $class->id }}"
                                {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                            @endforeach
                        </select>
                        <label for="class_id2">Second Class</label>
                        <select name="class_id2" id="class_id2" class="form-control">
                            <option value="" selected disabled>Select Class</option>
                            @foreach ($classes as $class)
                            <option value="{{ $class->id }}"
                                {{ request('class_id2') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="btn btn-primary">Compare</button>
                    </div>
                </form>

            </div>
            <div class="container mt-3">
                <canvas id="groupedBarChart" width="400" height="200"></canvas>
            </div>
        </main>


    </div>
</div>
@endsection

@section('page_js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const compareBySelect = document.getElementById('compare_by');
        const teacherFields = document.getElementById('teacher-fields');
        const schoolFields = document.getElementById('school-fields');
        const classFields = document.getElementById('class-fields');

        // Function to show relevant fields based on the selected option
        const showFields = (selectedOption) => {
            // Hide all fields initially
            teacherFields.style.display = 'none';
            schoolFields.style.display = 'none';
            classFields.style.display = 'none';

            // Show the relevant fields based on the selected option
            if (selectedOption === 'teachers') {
                teacherFields.style.display = 'block';
            } else if (selectedOption === 'schools') {
                schoolFields.style.display = 'block';
            } else if (selectedOption === 'classes') {
                classFields.style.display = 'block';
            }
        };

        // Check the current value of request('compare_by') and show the corresponding fields
        const initialCompareByValue = '{{ request("compare_by") }}';
        if (initialCompareByValue) {
            showFields(initialCompareByValue);
        }

        // Listen for changes in the 'compare_by' select field
        compareBySelect.addEventListener('change', function() {
            showFields(this.value);
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@if (isset($chartData))
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartData = @json($chartData);
    const legendLabels = @json($labels); // Array of 2 names passed from the controller
    const colors = ['#9e9fdc', '#0d6efd'];

    const grades = chartData.map(item => item.grade);
    const datasets = [];
    var index = 0;

    chartData.forEach((gradeData, gradeIndex) => {
        gradeData.assignments.forEach((assignment, assignmentIndex) => {
            console.log(gradeData, colors[index]);
            datasets.push({
                label: `${gradeData.grade} - ${assignment.name}`,
                data: chartData.map((_, index) =>
                    index === gradeIndex ? assignment.degree : null
                ),
                backgroundColor: gradeData.color,
                borderColor: gradeData.color,
                borderWidth: 1
            });
        });
    });

    const ctx = document.getElementById("groupedBarChart").getContext("2d");
    const groupedBarChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: grades,
            datasets: datasets
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        generateLabels: () => {
                            return legendLabels.map((label, i) => ({
                                text: label,
                                fillStyle: colors[i],
                                hidden: false
                            }));
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        title: (tooltipItems) => tooltipItems[0].dataset.label.split(" - ")[1]
                    }
                }
            },
            scales: {
                x: {
                    stacked: false,
                    title: {
                        display: true,
                        text: "Grades"
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: "Average Assignment Degree"
                    }
                }
            }
        }
    });
</script>


@endif

@endsection