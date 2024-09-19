<!-- resources/views/components/table.blade.php -->

<div class=" rounded-[8px] border border-[#D0D5DD] bg-[#FFFFFF]  space-x-2 flex items-center relative">
  <i class="fa-solid fa-search text-[#667085] w-[16.02px] h-[16.02px]"></i>
  
  <!-- Search Input -->
  <form method="GET" class="w-full">
      <input type="text" name="selectedName" placeholder="Enter Employee Name..." class="outline-none border-none placeholder-[#667085] bg-transparent text-sm md:text-base w-full" value="{{ request('selectedName') }}">
  </form>
</div>

<div class="mt-5 overflow-x-auto rounded-2xl border border-[#EAECF0]">
    <table class="w-full table-auto bg-[#FFFFFF] text-left text-[#475467]">
      <thead class="bg-[#F9FAFB] text-sm md:text-base">
        <tr>
          <th class="py-3 px-4 min-w-[120px] whitespace-nowrap">
            Title <i class="fa-solid fa-arrow-down mx-2"></i>
          </th>
          <th class="py-3 px-4 min-w-[120px] whitespace-nowrap">
            Due Date <i class="fa-solid fa-arrow-down mx-2"></i>
          </th>
          <th class="py-3 px-4 min-w-[120px] whitespace-nowrap">
            Description <i class="fa-solid fa-arrow-down mx-2"></i>
          </th>
          <th class="py-3 px-4 min-w-[120px] whitespace-nowrap">
            Actions <i class="fa-solid fa-arrow-down mx-2"></i>
          </th>
        </tr>
      </thead>
      <tbody>
        @if(count($tableData) === 0)
        <tr>
          <td colspan="3" class="px-4 py-2 h-[72px] text-center border-t border-gray-300 text-xs md:text-sm">
            No Data Found
          </td>
        </tr>
        @endif

        @foreach ($tableData as $row)
        <tr class="border-t border-gray-300 text-xs md:text-sm {{ $loop->index % 2 === 0 ? 'bg-[#F4F4F4]' : 'bg-white' }}">
          <td class="py-5 px-4">{{ $row['title'] }}</td>
          <td class="py-5 px-4">{{ $row['dueDate'] }}</td>
          <td class="py-5 px-4">{{ $row['desc'] }}</td>
          <td class="py-5 px-4">

            <i class="fas fa-edit text-[#101828] w-3 md:w-4"></i>
            <i class="fa fa-trash text-[#CC161D] ml-2 w-3 md:w-4"></i>


          </td>

        </tr>
        @endforeach
      </tbody>
    </table>
</div>
