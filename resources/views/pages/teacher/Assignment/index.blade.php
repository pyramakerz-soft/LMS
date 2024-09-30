@extends('layouts.app')

@section('title')
    Theme
@endsection

@php
    $menuItems = [
        ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('student.theme')],
        ['label' => 'Assignments', 'icon' => 'fas fa-home', 'route' => route('student.assignment')],
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
                    <img src="{{ asset('storage/students/profile-png.webp') }}" alt="Student Image"
                        class="w-30 h-20 rounded-full object-cover">
            </div>

            <div class="ml-3 font-semibold text-white flex flex-col space-y-2">
                <div class="text-xl">
                   menna
                </div>
                <div class="text-sm">
                   stage1
                </div>
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

        <a href="{{ route('teacher.Assignment.create') }}">
            <button class="rounded-md px-5 py-3 bg-[#17253E] text-white border-none">
                Create
            </button>
        </a>
    </div>
    @include('components.table', ['paths' => ['tableData' => $tableData]])
    </div> --}}

     <div class="flex justify-between items-center px-5"> 
         {{-- @include('components.path', ['paths' => $paths])  --}}

         <div class="p-3 text-[#667085] my-8">
            <i class="fa-solid fa-house mx-2"></i>
            <span class="mx-2 text-[#D0D5DD]">/</span>
            <a href="#" class="mx-2 cursor-pointer">Theme</a>
        </div>

        <a href="{{ route('teacher.Assignment.create') }}">
            <button class="rounded-md px-6 py-3 bg-[#17253E] text-white border-none">
                Create
            </button>
        </a>

     </div>


      <div class="p-5">

        {{-- <div class="rounded-lg border border-[#D0D5DD] bg-[#FFFFFF] flex space-x-4 items-center p-2">
          <i class="fa-solid fa-search text-[#667085] w-[20px] h-[20px]"></i>
          <form method="GET" class="w-full">
              <input type="text" name="selectedName" placeholder="Enter Employee Name..." class="outline-none border-none placeholder-[#667085] bg-transparent w-full" value="{{ request('selectedName') }}">
          </form>
        </div> --}}
        
        <div class=" overflow-x-auto rounded-2xl border border-[#EAECF0]">
            <table class="w-full table-auto bg-[#FFFFFF] text-left text-[#475467] text-lg md:text-xl">
              <thead class="bg-[#F9FAFB] text-lg md:text-xl">
                <tr>
                  <th class="py-4 px-6 min-w-[120px] whitespace-nowrap text-lg md:text-xl">
                    Title <i class="fa-solid fa-arrow-down mx-2"></i>
                  </th>
                  <th class="py-4 px-6 min-w-[120px] whitespace-nowrap text-lg md:text-xl">
                    Due Date <i class="fa-solid fa-arrow-down mx-2"></i>
                  </th>
                  <th class="py-4 px-6 min-w-[120px] whitespace-nowrap text-lg md:text-xl">
                    Description <i class="fa-solid fa-arrow-down mx-2"></i>
                  </th>
                  <th class="py-4 px-6 min-w-[120px] whitespace-nowrap text-lg md:text-xl">
                    Actions <i class="fa-solid fa-arrow-down mx-2"></i>
                  </th>
                </tr>
              </thead>
              <tbody>
               
        
                <tr class="border-t border-gray-300 text-lg md:text-xl  'bg-white' }}">
                  <td class="py-5 px-6">
                    <a href="{{ route('teacher.assignment.show') }}" class="text-blue-600 hover:underline">
                      title1
                  </a>
                </td>
                  <td class="py-5 px-6">duedate</td>
                  <td class="py-5 px-6">desc</td>
                  <td class="py-5 px-6">
                    <a href="{{ route('teacher.assignment.edit') }}">       {{-- add here['assignment_id' => $assignment->id] --}}
                      <i class="fas fa-edit text-[#101828] w-5 md:w-6"></i>
                  </a>
                      <i class="fa fa-trash text-[#CC161D] ml-2 w-5 md:w-6"></i>
                  </td>
                </tr>
        
              </tbody>
            </table>
        </div>
      </div>
      



@endsection

