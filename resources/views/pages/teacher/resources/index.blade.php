@php
    $userAuth = auth()->guard('teacher')->user();
@endphp

@extends('layouts.app')

@section('title')
    Resources
@endsection

@php
    $menuItems = [['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')]];
@endphp
@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection

@section('content')
    @include('components.profile')

    <div class="p-3">
        <div class="flex justify-between items-center px-5 my-8">
            <div class="text-[#667085]">
                <i class="fa-solid fa-house mx-2"></i>
                <span class="mx-2 text-[#D0D5DD]">/</span>
                <a href="#" class="mx-2 cursor-pointer">Resources</a>
            </div>

        </div>

        <div class="p-3">
            <div class="overflow-x-auto rounded-2xl border border-[#EAECF0]">
                <div class="container mx-auto px-4 py-8">
                    <h1 class="text-3xl font-bold mb-8">Your Resources </h1>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- PDF Resources Section -->
                        <div>
                            <h2 class="text-xl font-semibold mb-4">PDF Resources</h2>
                            @if ($pdfResources->isEmpty())
                                <p class="text-gray-500">No PDF resources available.</p>
                            @else
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    @foreach ($pdfResources as $resource)
                                        <div class="col-md-4">
                                            <div class="card mb-3">
                                                <img src="{{ asset($resource->image) }}" class="card-img-top"
                                                    alt="{{ $resource->name }}">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $resource->name }}</h5>
                                                    <a href="{{ asset($resource->file_path) }}"
                                                        class="btn btn-primary" target="_blank">View PDF</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Ebook Resources Section -->
                        <div>
                            <h2 class="text-xl font-semibold mb-4">Ebook Resources</h2>
                            @if ($ebookResources->isEmpty())
                                <p class="text-gray-500">No eBook resources available.</p>
                            @else
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    @foreach ($ebookResources as $resource)
                                        <div class="col-md-4">
                                            <div class="card mb-3">
                                                <img src="{{ asset($resource->image) }}" class="card-img-top"
                                                    alt="{{ $resource->name }}">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $resource->name }}</h5>
                                                    <a href="{{ asset($resource->file_path) }}"
                                                        class="btn btn-primary" target="_blank">View eBook</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
