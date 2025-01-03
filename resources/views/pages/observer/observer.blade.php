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
            <form id="filter-form" action="{{ route('observer.dashboard') }}" method="GET" enctype="multipart/form-data" class="flex" style="gap:10px;">
                <div>
                    <select name="teacher_id" id="teacher_id" class="w-full p-2 border border-gray-300 rounded">
                        <option value="">All Teachers</option>
                        @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}"
                            {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->username }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </form>
            <a href="{{ route('observer.observation.create') }}" class="px-4 py-2 text-white rounded-md hover:bg-blue-700" style="background-color:#667085; display:block">Add New Observation</a>
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


    <div class="overflow-x-auto w-full">
        <table class="w-full border border-gray-300 text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Observer Name</th>
                    <th class="border px-4 py-2">Teacher Name</th>
                    <th class="border px-4 py-2">Co-Teacher Name</th>
                    <th class="border px-4 py-2">School</th>
                    <th class="border px-4 py-2">Date of Observation</th>
                    <th class="border px-4 py-2">Comment</th>
                    <th class="border px-4 py-2" style="width: 15%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($observations as $observation)
                <tr>
                    <td class="border px-4 py-2">{{ App\Models\Observer::find($observation->observer_id)->name }}</td>
                    <td class="border px-4 py-2">{{ $observation->teacher_name }}</td>
                    <td class="border px-4 py-2">{{ $observation->coteacher_name }}</td>
                    <td class="border px-4 py-2">{{ App\Models\School::find($observation->school_id)->name }}</td>
                    <td class="border px-4 py-2">{{ $observation->activity }}</td>
                    <td class="border px-4 py-2">{{ $observation->note }}</td>
                    <td class="border px-4 py-2" style="text-align:center; gap:10px">

                        <a href="{{ route('observation.view', $observation->id) }}"
                            class="text-white font-medium py-2 px-4 rounded shadow focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50" style="background-color:#667085">
                            <i class="fa-solid fa-eye"></i></a>
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
@endsection

@section('page_js')
<script>
    document.getElementById('teacher_id').addEventListener('change', function() {
        document.getElementById('filter-form').submit();
    });
</script>
@endsection