@extends('layouts.app')

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
<div class="p-3 text-[#667085] my-8" style="padding:20px">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Observations</h1>
        <div class="flex" style="justify-content:center; align-items:center;gap:15px">
            <!-- Trigger for Filter Modal -->
            <button id="filter-modal-btn" class="px-4 py-2 text-white rounded-md hover:bg-blue-700" style="background-color:#667085;">
                Filters
            </button>
            <a href="{{ route('observer.observation.create') }}" class="px-4 py-2 text-white rounded-md hover:bg-blue-700" style="background-color:#667085; display:block">
                Add New Observation
            </a>
        </div>
    </div>

    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-green-700" onclick="this.parentElement.remove();">
            <svg class="fill-current h-6 w-6 text-green-700" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.586 7.066 4.652a1 1 0 10-1.414 1.414L8.586 10l-2.93 2.934a1 1 0 101.414 1.414L10 12.414l2.934 2.934a1 1 0 101.414-1.414L11.414 10l2.934-2.934z" />
            </svg>
        </button>
    </div>
    @endif
    @if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-red-700" onclick="this.parentElement.remove();">
            <svg class="fill-current h-6 w-6 text-red-700" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.586 7.066 4.652a1 1 0 10-1.414 1.414L8.586 10l-2.93 2.934a1 1 0 101.414 1.414L10 12.414l2.934 2.934a1 1 0 101.414-1.414L11.414 10l2.934-2.934z" />
            </svg>
        </button>
    </div>
    @endif

    <div class="overflow-x-auto w-full">
        <table class="w-full border border-gray-300 text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Observation Name</th>
                    <!-- <th class="border px-4 py-2">Observer Name</th> -->
                    <th class="border px-4 py-2">Teacher Name</th>
                    <th class="border px-4 py-2">Co-Teacher Name</th>
                    <th class="border px-4 py-2">School</th>
                    <th class="border px-4 py-2">City</th>
                    <th class="border px-4 py-2">Date of Observation</th>
                    <th class="border px-4 py-2" style="width: 15%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($observations as $observation)
                <tr>
                    @php
                    $school = App\Models\School::find($observation->school_id);
                    @endphp
                    <td class="border px-4 py-2">{{ $observation->name }}</td>
                    <!-- <td class="border px-4 py-2">{{ App\Models\Observer::find($observation->observer_id)->name }}</td> -->
                    <td class="border px-4 py-2">{{ $observation->teacher_name }}</td>
                    <td class="border px-4 py-2">{{ $observation->coteacher_name }}</td>
                    <td class="border px-4 py-2">{{ $school->name }}</td>
                    <td class="border px-4 py-2">{{ $school->city }}</td>
                    <td class="border px-4 py-2">{{ $observation->activity }}</td>
                    <td class="border px-4 py-2" style="text-align:center; ">
                        <a href="{{ route('observation.view', $observation->id) }}"
                            class="text-white font-medium py-2 px-4 rounded shadow focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50" style="background-color:#667085; margin-right:5px;">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <form action="{{ route('observation.destroy', $observation->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded shadow focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50"
                                onclick="return confirm('Are you sure you want to delete this Observation?');">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="border px-4 py-2 text-center">No observations found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div id="filter-modal">
    <div>
        <h2>Filters</h2>
        <form id="filter-form-modal" action="{{ route('observer.dashboard') }}" method="GET">
            <div>
                <label for="teacher_id_modal">Teacher</label>
                <select name="teacher_id" id="teacher_id_modal">
                    <option value="">All Teachers</option>
                    @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="school_id">School</label>
                <select name="school_id[]" id="school_id" multiple>
                    <!-- <option value="" disabled selected>Select Schools</option> -->
                    @foreach ($schools as $school)
                    <option value="{{ $school->id }}"
                        {{ is_array(request('school_id')) && in_array($school->id, request('school_id')) ? 'selected' : '' }}>
                        {{ $school->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="city">City</label>
                <select name="city[]" id="city" multiple>
                    <!-- <option value="" disabled selected>Select Schools</option> -->
                    @foreach ($cities as $city)
                    <option value="{{ $city }}"
                        {{ is_array(request('city')) && in_array($city, request('city')) ? 'selected' : '' }}>
                        {{ $city }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="school_id">Stage</label>
                <select name="stage_id" id="stage_id">
                    <option value="">All Stages</option>
                    @foreach ($stages as $stage)
                    <option value="{{ $stage->id }}" {{ request('stage_id') == $stage->id ? 'selected' : '' }}>
                        {{ $stage->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="lesson_segment_filter">Lesson Segment</label>
                <select name="lesson_segment_filter" id="lesson_segment_filter">
                    <option value="">All</option>
                    <option value="Beginning" {{ request('lesson_segment_filter') == 'Beginning' ? 'selected' : '' }}>Beginning</option>
                    <option value="Middle" {{ request('lesson_segment_filter') == 'Middle' ? 'selected' : '' }}>Middle</option>
                    <option value="End" {{ request('lesson_segment_filter') == 'End' ? 'selected' : '' }}>End</option>
                </select>
            </div>
            <div>
                <label for="from_date" class="block text-sm font-medium text-gray-700">Date From</label>
                <input type="date" name="from_date" id="from_date" value="{{ request('from_date') }}">
            </div>
            <div class="mb-4">
                <label for="to_date" class="block text-sm font-medium text-gray-700">Date To</label>
                <input type="date" name="to_date" id="to_date" value="{{ request('to_date') }}">
            </div>
            <input type="checkbox" name="include_comments" value="1" {{ request('include_comments') ? 'checked' : '' }}> Includes Comments
            <div>
                <button type="button" id="close-modal-btn">Close</button>
                <button type="submit">Apply Filters</button>
            </div>
        </form>
    </div>
</div>

<style>
    #filter-modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50%;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        z-index: 1001;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    #filter-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    #filter-modal h2 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    #filter-modal label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }

    #filter-modal select,
    #filter-modal input {
        width: 100%;
        padding: 0.5rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    #filter-modal button {
        padding: 0.5rem 1rem;
        margin-top: 1rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    #filter-modal button#close-modal-btn {
        background-color: #ccc;
        margin-right: 1rem;
    }

    #filter-modal button[type="submit"] {
        background-color: #667085;
        color: white;
    }
</style>

@endsection

@section('page_js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const filterModalBtn = document.getElementById("filter-modal-btn");
        const filterModal = document.getElementById("filter-modal");
        const filterModalOverlay = document.createElement("div");
        filterModalOverlay.id = "filter-modal-overlay";
        document.body.appendChild(filterModalOverlay);

        const closeModalBtn = document.getElementById("close-modal-btn");

        filterModalBtn.addEventListener("click", () => {
            filterModal.style.display = "block";
            filterModalOverlay.style.display = "block";
        });

        closeModalBtn.addEventListener("click", () => {
            filterModal.style.display = "none";
            filterModalOverlay.style.display = "none";
        });

        filterModalOverlay.addEventListener("click", () => {
            filterModal.style.display = "none";
            filterModalOverlay.style.display = "none";
        });
    });
</script>
@endsection