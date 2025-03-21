@extends('layouts.app')
<style>
    /* Make radio buttons oval */
    .custom-radio {
        appearance: none;
        /* Remove default styling */
        width: 25px;
        height: 15px;
        border-radius: 10px;
        /* Oval shape */
        border: 2px solid #17253e;
        /* Indigo border color */
        background-color: white;
        outline: none;
        cursor: pointer;
        transition: background-color 0.2s ease, box-shadow 0.2s ease;
    }

    .custom-radio:checked {
        background-color: #17253e;
        /* Indigo background color when selected */
    }

    .custom-radio:hover {
        background-color: rgba(79, 70, 229, 0.1);
        /* Light hover effect */
    }
</style>
@section('title')
    Observer Dashboard
@endsection

@php
    $menuItems = [
        ['label' => 'Observations', 'icon' => 'fi fi-rr-table-rows', 'route' => route('observer.dashboard')],
        ['label' => 'Observations Report', 'icon' => 'fi fi-rr-table-rows', 'route' => route('observer.report')],
    ];
@endphp

@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection

@section('content')
    <div class="p-3 text-[#667085] my-8">
        <div class="overflow-x-auto">
            <form action="{{ route('observation.store') }}" method="GET" enctype="multipart/form-data" class="mb-4 flex"
                style="gap:10px; padding:10px">
                @csrf
                <div class="questions mb-3" style="max-width: 70%;">
                    @php
                        $index = -1;
                    @endphp
                    @foreach ($headers as $header)
                        <h1 class="text-lg font-semibold text-[#667085] mb-4" style="font-size:24px">{{ $header->header }}
                        </h1>
                        @php
                            $questions = App\Models\ObservationQuestion::where(
                                'observation_header_id',
                                $header->id,
                            )->get();
                        @endphp
                        @foreach ($questions as $question)
                            @php
                                $index++;
                            @endphp
                            <h3 class="text-base font-medium text-gray-700 mb-2" style="font-size:18px">-
                                {{ $question->question }}</h3>
                            <div class="mb-6">
                                <p class="block text-sm font-medium text-gray-500 mb-2">Mark only one oval</p>
                                <div class="flex items-center space-x-6">
                                    @for ($i = 0; $i < $question->max_rate; $i++)
                                        <div class="flex flex-col items-center ml-3">
                                            <input type="radio" id="{{ $question->id . '-' . $i }}"
                                                name="question-{{ $question->id }}" value="{{ $i }}"
                                                class="custom-radio" required disabled
                                                @if (isset($answers[$index]->rate) && $answers[$index]->rate == $i) checked @endif>
                                            <label for="{{ $question->id . '-' . $i }}"
                                                class="text-sm text-gray-700 mt-1">{{ $i }}</label>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        @endforeach
                    @endforeach

                    <h1 class="text-lg font-semibold text-[#667085] mb-4" style="font-size:24px">Overall Comments</h1>
                    <h3 class="text-base font-medium text-gray-700 mb-2" style="font-size:18px">- Provide an overall
                        assessment of the teacher's effectiveness in teaching STEAM. Highlight strenghts, areas for
                        improvement, and recommendations for professional development</h3>
                    <textarea name="note" placeholder="Enter your comments here..."
                        class="w-full mb-3 p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        rows="5" disabled>{{ $observation->note }}</textarea>

                </div>
                <div class="w-1/3 p-4 bg-gray-50 border border-gray-200 rounded-lg shadow-lg">
                    <div class="info mb-3">
                        <div class="mb-3">
                            <label for="observation_name" class="block text-sm font-medium text-gray-700">Observation
                                Name</label>
                            <input class="w-full p-2 border border-gray-300 rounded" type="text" name="observation_name"
                                value="{{ $observation->name }}" disabled required>
                        </div>
                        <div class="mb-3">
                            <label for="observer" class="block text-sm font-medium text-gray-700">Observer Username</label>
                            <select name="observer_id" id="observer_id" class="w-full p-2 border border-gray-300 rounded"
                                required>
                                <option value="{{ $observer->id }}">{{ $observer->username }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="teacher" class="block text-sm font-medium text-gray-700">Teacher Username</label>
                            <select name="teacher_id" id="teacher_id" class="w-full p-2 border border-gray-300 rounded"
                                required>
                                <option value="">{{ $observation->teacher_name }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="coteacher" class="block text-sm font-medium text-gray-700">Co-Teacher
                                Username</label>
                            <select name="coteacher_id" id="coteacher_id" class="w-full p-2 border border-gray-300 rounded"
                                required>
                                <option value="">{{ $observation->coteacher_name ?? 'None' }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="school" class="block text-sm font-medium text-gray-700">School</label>
                            <select name="school_id" id="school_id" class="w-full p-2 border border-gray-300 rounded"
                                required>
                                <option value="{{ $observation->school_id }}">
                                    {{ App\Models\School::find($observation->school_id)->name }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                            <select name="city_id" id="city_id" class="w-full p-2 border border-gray-300 rounded"
                                required>
                                <option value="" selected disabled>
                                    {{ App\Models\School::find($observation->school_id)->city }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="grade" class="block text-sm font-medium text-gray-700">Grade</label>
                            <select name="grade_id" id="grade_id" class="w-full p-2 border border-gray-300 rounded"
                                required>
                                <option value="{{ $observation->stage_id }}" selected disabled>
                                    {{ App\Models\Stage::find($observation->stage_id)->name }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="lesson_segment" class="block text-sm font-medium text-gray-700">Subject Area</label>
                            <select class="w-full p-2 border border-gray-300 rounded" name="lesson_segment[]"
                                id="lesson_segment" multiple required disabled style="overflow: hidden;">
                                @if ($observation->lesson_segment)
                                    @foreach (json_decode($observation->lesson_segment, true) as $segment)
                                        <option value="{{ $segment }}" selected>{{ $segment }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class=" mb-3">
                            <label for="date" class="block text-sm font-medium text-gray-700">Date of
                                Observation</label>
                            <input type="date" name="date" required class="w-full p-2 border border-gray-300 rounded"
                                value="{{ $observation->activity }}">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


<style>
    /* Style for dimmed options */
    .dim-option {
        color: gray;
        /* Dimmed text color */
        background-color: #ddd;
        /* Optional: dimmed background color */
        pointer-events: none;
        /* Prevent interaction */
        cursor: not-allowed;
        /* Change cursor to indicate non-clickable */
    }
</style>
@section('page_js')
    <script>
        $(document).ready(function() {

            function updateOptions(selectedValue, selectToUpdate) {
                // Enable all options first
                $(`#${selectToUpdate} option`).prop('disabled', false);

                // Disable the matching option in the other select
                if (selectedValue) {
                    $(`#${selectToUpdate} option[value="${selectedValue}"]`).prop('disabled', true);
                    $(`#${selectToUpdate} option[value="${selectedValue}"]`).addClass('dim-option');
                }
            }

            // Trigger getProgramsByGroup on group change
            $('#teacher_id').change(function() {
                var teacherId = $('#teacher_id').val();
                updateOptions(teacherId, 'coteacher_id'); // Update coteacher dropdown
                getSchool(teacherId);
                getStages(teacherId);
            });

            $('#coteacher_id').change(function() {
                var coteacherId = $('#coteacher_id').val();
                updateOptions(coteacherId, 'teacher_id'); // Update teacher dropdown
            });

            // Trigger change on page load to fetch programs for the selected group
            $('#teacher_id').trigger('change');
        });



        function getSchool(teacherId) {
            $.ajax({
                url: '/LMS/lms_pyramakerz/public/observer/observation/get_school/' + teacherId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    // Clear the existing options
                    $('select[name="school_id"]').empty();
                    $('select[name="city_id"]').empty();

                    if (data.error) {
                        $('select[name="school_id"]').append(
                            '<option value="" selected disabled>' + data.error + '</option>'
                        );
                    } else {
                        $('select[name="school_id"]').append(
                            '<option value="' + data.id + '" selected disabled>' + data.name + '</option>'
                        );
                        $('select[name="city_id"]').append(
                            '<option value="' + data.city + '" selected disabled>' + data.city + '</option>'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }

        function getStages(teacherId) {
            $.ajax({
                url: '/LMS/lms_pyramakerz/public/observer/observation/get_stages/' + teacherId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    // Clear the existing options
                    $('select[name="grade_id"]').empty();
                    if (!data || data.length === 0) {
                        $('select[name="grade_id"]').append(
                            '<option value="" selected disabled>No Available School</option>'
                        );
                    } else {
                        $.each(data, function(key, value) {
                            $('select[name="grade_id"]').append(
                                '<option value="' + value.id + '">' + value.name + '</option>'
                            );
                        });

                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
    </script>
@endsection
