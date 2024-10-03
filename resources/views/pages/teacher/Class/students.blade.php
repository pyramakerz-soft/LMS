@extends('layouts.app')

@section('title')
    Students in {{ $class->class->name }}
@endsection

{{-- @section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection --}}

@section('content')
    <div class="p-3">
        <h2 class="text-xl font-bold mb-4">Students in {{ $class->class->name }}</h2>

        @if (count($students) == 0)
            <p>No students are currently assigned to this class.</p>
        @else
            <ul class="list-disc list-inside">
                @foreach ($students as $student)
                    <li class="mb-2">{{ $student->name }} - {{ $student->email }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
