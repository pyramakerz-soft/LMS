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

        <div id="timer"
            style="
    margin-bottom: 20px;
    color: #fff;
    background-color: #17253e;
    padding: 10px 20px;
    border-radius: 8px;
    text-align: center;
    font-size: 1.2rem;
    font-weight: bold;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
">
            {{-- Timer: 25:00 --}}
        </div>

        <div class="overflow-x-auto">
            <form action="{{ route('observation.store') }}" id="obsform" method="GET" enctype="multipart/form-data"
                class="mb-4 flex" style="gap:10px; padding:10px" id="observation_form">
                @csrf


                <div class="questions mb-3" style="max-width: 65%;">
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
                            <h3 class="text-base font-medium text-gray-700 mb-2" style="font-size:18px">-
                                {{ $question->question }}</h3>
                            <div class="mb-6">
                                <p class="block text-sm font-medium text-gray-500 mb-2">Mark only one oval</p>
                                <div class="flex items-center space-x-6">
                                    @for ($i = 0; $i < $question->max_rate; $i++)
                                        <div class="flex flex-col items-center ml-3">
                                            <input type="radio" id="{{ $question->id . '-' . $i }}"
                                                name="question-{{ $question->id }}" value="{{ $i }}"
                                                class="custom-radio" required>
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
                        class="w-full mb-3 p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-black focus:border-black"
                        rows="4"></textarea>

                    <button type="submit" id="submit-button" class="mt-2 text-white hover:bg-blue-700 px-4 py-2 rounded-lg"
                        style="background-color: #17253e;">Create Observation</button>
                </div>
                <div class="w-1/3 p-4 bg-gray-50 border border-gray-200 rounded-lg shadow-lg">
                    <div class="info mb-3">
                        <div class="mb-3">
                            <label for="observation_name" class="block text-sm font-medium text-gray-700">Observation
                                Name</label>
                            <input class="w-full p-2 border border-gray-300 rounded" type="text" name="observation_name"
                                required>
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
                                <option value="">Select Teacher</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="school" class="block text-sm font-medium text-gray-700">School</label>
                            <select name="school_id" id="school_id" class="w-full p-2 border border-gray-300 rounded"
                                required>
                                <option value="" selected disabled>No Available School</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="coteacher" class="block text-sm font-medium text-gray-700">Co-Teacher
                                Username</label>
                            <select name="coteacher_id" id="coteacher_id" class="w-full p-2 border border-gray-300 rounded">
                                <option value="">None</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                            <select name="city_id" id="city_id" class="w-full p-2 border border-gray-300 rounded"
                                required>
                                <option value="" disabled selected>Select City</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="grade" class="block text-sm font-medium text-gray-700">Grade</label>
                            <select name="grade_id" id="grade_id" class="w-full p-2 border border-gray-300 rounded"
                                required>
                                <option value="" disabled selected>Select Grade</option>
                                @foreach ($grades as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="lesson_segment" class="block text-sm font-medium text-gray-700">Subject
                                Area(Multiselect)</label>
                            <select class="w-full p-2 border border-gray-300 rounded" name="lesson_segment[]"
                                id="lesson_segment" multiple required style="overflow: hidden;">
                                <option value="Beginning">Beginning</option>
                                <option value="Middle">Middle</option>
                                <option value="End">End</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="block text-sm font-medium text-gray-700">Date of
                                Observation</label>
                            <input type="date" name="date" required
                                class="w-full p-2 border border-gray-300 rounded">
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
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("obsform");

            form.addEventListener("submit", function() {
                const submitButton = form.querySelector("[type='submit']");
                submitButton.disabled = true; // Disable the button
                submitButton.innerHTML = "Submitting..."; // Optional: Change button text
            });
        });
    </script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            localStorage.setItem('lastSubmissionTime', new Date().getTime());
            const submitButton = document.getElementById('submit-button');
            const form = document.getElementById('my-form');
            const restrictionTime = 1 * 60 * 1000 - 1000; // 25 minutes in milliseconds
            // const restrictionTime = 0; // 25 minutes in milliseconds

            // Check localStorage for last submission time
            const lastSubmissionTime = localStorage.getItem('lastSubmissionTime');
            const now = new Date().getTime();

            // If last submission time exists and 25 minutes haven't passed
            if (lastSubmissionTime && now - lastSubmissionTime < restrictionTime) {
                const remainingTime = Math.ceil((restrictionTime - (now - lastSubmissionTime)) / 1000);

                // Start the countdown
                startCountdown(remainingTime);

                // Disable the submit button
                submitButton.disabled = true;
            } else {
                // Allow submission if restriction time has passed
                timerElement.textContent = 'You can now submit the form.';
            }

            // Form submission handler
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent form submission for demo purposes
                localStorage.setItem('lastSubmissionTime', new Date().getTime());
                submitButton.disabled = true;
                startCountdown(25 * 60);
            });

            function startCountdown(seconds) {
                let remainingTime = seconds;
                const interval = setInterval(() => {
                    if (remainingTime <= 0) {
                        clearInterval(interval);
                        timerElement.textContent = 'You can now submit the form.';
                        submitButton.disabled = false;
                    } else {
                        const minutes = Math.floor(remainingTime / 60);
                        const seconds = remainingTime % 60;
                        timerElement.textContent =
                            `Timer:  ${minutes}:${seconds.toString().padStart(2, '0')}`;
                        remainingTime--;
                    }
                }, 1000);
            }
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            function updateOptions(selectedValue, selectToUpdate) {
                // Enable all options first
                $(`#${selectToUpdate} option`).prop("disabled", false);

                // Disable the matching option in the other select
                if (selectedValue) {
                    $(`#${selectToUpdate} option[value="${selectedValue}"]`)
                        .prop("disabled", true)
                        .addClass("dim-option");
                }
            }

            // Trigger getProgramsByGroup on group change
            $("#teacher_id").change(function() {
                var teacherId = $("#teacher_id").val();
                updateOptions(teacherId, "coteacher_id"); // Update coteacher dropdown
                getSchool(teacherId);
            });

            $("#coteacher_id").change(function() {
                var coteacherId = $("#coteacher_id").val();
                updateOptions(coteacherId, "teacher_id"); // Update teacher dropdown
            });

            // Trigger change on page load to fetch programs for the selected group
            $("#teacher_id").trigger("change");

            // Update city select when school is selected
            $("select[name='school_id']").change(function() {
                var selectedSchool = $(this).find(":selected");
                var schoolCity = selectedSchool.data("city"); // Retrieve the city from the data attribute
                var citySelect = $("select[name='city_id']");

                citySelect.empty(); // Clear existing city options
                if (schoolCity) {
                    citySelect.append(
                        '<option value="' + schoolCity + '" selected>' + schoolCity + '</option>'
                    );
                }
            });
        });

        function getSchool(teacherId) {
            $.ajax({
                url: '/LMS/lms_pyramakerz/public/observer/observation/get_school/' + teacherId,
                // url: "/observer/observation/get_school/" + teacherId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    // Clear the existing options
                    $("select[name='school_id']").empty();

                    if (data.error) {
                        $("select[name='school_id']").append(
                            '<option value="" selected disabled>' + data.error + "</option>"
                        );
                    } else {
                        // Loop through each school and append them to the school_id dropdown
                        $("select[name='school_id']").append(
                            '<option value="" selected disabled>Select School</option>'
                        );
                        data.forEach(function(school) {
                            $("select[name='school_id']").append(
                                '<option value="' +
                                school.id +
                                '" data-city="' +
                                school.city +
                                '">' +
                                school.name +
                                "</option>"
                            );
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                },
            });
        }

        function getStages(teacherId) {
            $.ajax({
                url: '/LMS/lms_pyramakerz/public/observer/observation/get_stages/' + teacherId,
                // url: '/observer/observation/get_stages/' + teacherId,
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
    <script>
        $(document).ready(function() {
            $("select[name='school_id']").change(function() {
                var schoolId = $(this).val();
                var coteacherSelect = $("select[name='coteacher_id']");

                if (schoolId) {
                    $.ajax({
                        url: '/LMS/lms_pyramakerz/public/observer/observation/get_coteachers/' + schoolId,
                        // url: "/observer/observation/get_coteachers/" + schoolId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            coteacherSelect.empty();
                            coteacherSelect.append(
                                '<option value="">Select Co-Teacher</option>');

                            if (data.length > 0) {
                                $.each(data, function(key, value) {
                                    coteacherSelect.append(
                                        '<option value="' + value.id + '">' + value
                                        .name + '</option>'
                                    );
                                });
                            } else {
                                coteacherSelect.append(
                                    '<option value="" disabled>No Co-Teachers Available</option>'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", error);
                        }
                    });
                } else {
                    coteacherSelect.empty();
                    coteacherSelect.append('<option value="">Select Co-Teacher</option>');
                }
            });
        });
    </script>
@endsection
