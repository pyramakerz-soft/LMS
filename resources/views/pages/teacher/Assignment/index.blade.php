@extends('layouts.app')

@section('title')
    Assignments
@endsection

@php
    $menuItems = [
        ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')],
    ];

@endphp
@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection


@section('content')
  <div class="p-3">
    <div class="rounded-lg flex items-center justify-between py-3 px-6 bg-[#2E3646]">
        <div class="flex items-center space-x-4">
            <div>
                {{-- <img class="w-20 h-20 rounded-full" alt="avatar1" src="{{ Auth::guard('student')->user()->image }}" /> --}}
                @if ($userAuth->image)
                    <img src="{{ asset('storage/' . $userAuth->image) }}" alt="Student Image"
                        class="w-20 h-20 rounded-full object-cover">
                @else
                    <img src="{{ asset('storage/students/profile-png.webp') }}" alt="Student Image"
                        class="w-30 h-20 rounded-full object-cover">
                @endif
            </div>

            <div class="ml-3 font-semibold text-white flex flex-col space-y-2">
                <div class="text-xl">
                    {{ $userAuth->username }}
                </div>
            </div>

            <div class="relative">
                <i class="fa-solid fa-bell text-[#FF7519] text-xl"></i>
                <span
                    class="absolute -top-2 -right-2 bg-black border-2 border-white text-white rounded-full text-[10px] px-1 py-0.25">5</span>
            </div>
        </div>
        @yield('insideContent')
    </div>
    {{-- <div class="">
    <div class="flex justify-between items-center">
        @include('components.path', ['paths' => $paths])

  <div class="flex justify-between items-center p-3"> 
      <div class="text-[#667085] my-8">
        <i class="fa-solid fa-house mx-2"></i>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="#" class="mx-2 cursor-pointer">Assignment</a>
    </div>

    <div class="flex justify-between items-center px-5">
        {{-- @include('components.path', ['paths' => $paths])  --}}

        <div class="p-3 text-[#667085] my-8">
            <i class="fa-solid fa-house mx-2"></i>
            <span class="mx-2 text-[#D0D5DD]">/</span>
            <a href="#" class="mx-2 cursor-pointer">Assignment</a>
        </div>
    <a href="{{ route('assignments.create') }}">
        <button class="rounded-md px-6 py-3 bg-[#17253E] text-white border-none">
            Create
        </button>
    </a>

  </div>

  <div class="p-3">
    <div class=" overflow-x-auto rounded-2xl border border-[#EAECF0]">
        <table class="w-full table-auto bg-[#FFFFFF] text-left text-[#475467] text-lg md:text-xl">
          <thead class="bg-[#F9FAFB] text-lg md:text-xl">
            <tr>
              <th class="py-4 px-6 min-w-[120px] whitespace-nowrap text-lg md:text-xl">
                Title <i class="fa-solid fa-arrow-down mx-2"></i>
              </th>
              <th class="py-4 px-6 min-w-[120px] whitespace-nowrap text-lg md:text-xl">
                Description <i class="fa-solid fa-arrow-down mx-2"></i>
              </th>
              <th class="py-4 px-6 min-w-[120px] whitespace-nowrap text-lg md:text-xl">
                Due Date <i class="fa-solid fa-arrow-down mx-2"></i>
              </th>
              <th class="py-4 px-6 min-w-[120px] whitespace-nowrap text-lg md:text-xl">
                start_date <i class="fa-solid fa-arrow-down mx-2"></i>
              </th>
              <th class="py-4 px-6 min-w-[120px] whitespace-nowrap text-lg md:text-xl">
                marks <i class="fa-solid fa-arrow-down mx-2"></i>
              </th>
              <th class="py-4 px-6 min-w-[120px] whitespace-nowrap text-lg md:text-xl">
                Lesson <i class="fa-solid fa-arrow-down mx-2"></i>
              </th>
              <th class="py-4 px-6 min-w-[120px] whitespace-nowrap text-lg md:text-xl">
                School <i class="fa-solid fa-arrow-down mx-2"></i>
              </th>
              <th class="py-4 px-6 min-w-[120px] whitespace-nowrap text-lg md:text-xl">
                Actions <i class="fa-solid fa-arrow-down mx-2"></i>
              </th>
            </tr>
          </thead>
          <tbody>
            @if(count($Assignment) === 0)
            <tr>
              <td colspan="4" class="px-4 py-4 h-[72px] text-center border-t border-gray-300 text-lg md:text-xl">
                No Data Found
              </td>
            </tr>
            @endif

            @foreach ($Assignment as $row)
              <tr class="border-t border-gray-300 text-lg md:text-xl {{ $loop->index % 2 === 0 ? 'bg-[#F4F4F4]' : 'bg-white' }}">
                <td class="py-5 px-6">{{ $row['title'] }}</td>
                <td class="py-5 px-6">{{ $row['description'] }}</td>
                <td class="py-5 px-6">{{ $row['due_date'] }}</td>
                <td class="py-5 px-6">{{ $row['start_date'] }}</td>
                <td class="py-5 px-6">{{ $row['marks'] }}</td>
                <td class="py-5 px-6">{{ $row['lesson']['title'] ?? 'N/A' }}</td>
                <td class="py-5 px-6">{{  $row['school']['name']?? 'N/A' }}</td>

                <td class="py-5 px-6">
                  <a href="{{ route('assignments.edit', $row->id) }}"> 
                    <i class="fas fa-edit text-[#101828] w-5 md:w-6"></i>
                  </a>
                  <form action="{{ route('assignments.destroy', $row->id) }}" method="POST"
                    style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to delete this assignment?');">
                        <i class="fa fa-trash text-[#CC161D] ml-2 w-5 md:w-6"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
    </div>
  </div>
@endsection
