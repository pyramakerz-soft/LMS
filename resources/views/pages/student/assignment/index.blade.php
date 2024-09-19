@extends('pages.student.student')

@section('title')
    Assignment
@endsection


@php
    $paths = [
        ["name" => "Assignment", "url" => "student.assignment"],
    ];
    $tableData = [
        [
            'title' => 'Task 1',
            'dueDate' => '2024-09-30',
            'desc' => 'Description for Task 1',
            "url" => "student.assignment.show"
        ],
        [
            'title' => 'Task 2',
            'dueDate' => '2024-10-05',
            'desc' => 'Description for Task 2',
            "url" => "student.assignment.show"
        ],
    ];
@endphp

@section("insideContent")
    @include('components.path', ["paths" => $paths])
    <div>
        <div class="rounded-lg border border-[#D0D5DD] bg-[#FFFFFF] flex space-x-4 items-center p-2">
            <i class="fa-solid fa-search text-[#667085] w-[20px] h-[20px]"></i>
            <form method="GET" class="w-full">
                <input type="text" name="selectedName" placeholder="Enter Employee Name..." class="outline-none border-none placeholder-[#667085] bg-transparent w-full" value="{{ request('selectedName') }}">
            </form>
        </div>

          <div class="mt-5 overflow-x-auto rounded-2xl border border-[#EAECF0]">
            <table class="w-full table-auto bg-[#FFFFFF] text-left text-[#475467] text-lg md:text-xl">
              <thead class="bg-[#F9FAFB]">
                <tr>
                  <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">
                    Title <i class="fa-solid fa-arrow-down mx-2"></i>
                  </th>
                  <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">
                    Due Date <i class="fa-solid fa-arrow-down mx-2"></i>
                  </th>
                  <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">
                    Description <i class="fa-solid fa-arrow-down mx-2"></i>
                  </th>
                  <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">
                    Actions <i class="fa-solid fa-arrow-down mx-2"></i>
                  </th>
                </tr>
              </thead>
              <tbody>
                @if(count($tableData) === 0)
                <tr>
                  <td colspan="4" class="px-4 py-4 h-[72px] text-center border-t border-gray-300">
                    No Data Found
                  </td>
                </tr>
                @endif
        
                @foreach ($tableData as $row)
                <tr class="border-t border-gray-300 {{ $loop->index % 2 === 0 ? 'bg-[#F4F4F4]' : 'bg-white' }}">
                  <td class="py-5 px-6">{{ $row['title'] }}</td>
                  <td class="py-5 px-6">{{ $row['dueDate'] }}</td>
                  <td class="py-5 px-6">{{ $row['desc'] }}</td>
                  <td class="py-5 px-6">
                    <a href="{{route($row['url'])}}" class="text-[#FF7519] cursor-pointer"> 
                        View Assignments
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
        </div>
    </div>
@endsection
