<div class="mt-5 overflow-x-auto rounded-2xl border border-[#EAECF0]">
    <table class="w-full table-auto bg-[#FFFFFF] text-left text-[#475467]">
        <thead class="bg-[#F9FAFB] text-sm md:text-base">
            <tr>
                <th class="py-3 px-4 min-w-[120px] whitespace-nowrap">Name</th>
                <th class="py-3 px-4 min-w-[120px] whitespace-nowrap">Attendance</th>
                <th class="py-3 px-4 min-w-[120px] whitespace-nowrap">Classroom Participation</th>
                <th class="py-3 px-4 min-w-[120px] whitespace-nowrap">Classroom Behavior</th>
                <th class="py-3 px-4 min-w-[120px] whitespace-nowrap">Homework</th>
                <th class="py-3 px-4 min-w-[120px] whitespace-nowrap">Final Project</th>
            </tr>
        </thead>
        <tbody>
            @if(count($tableData) === 0)
            <tr>
                <td colspan="6" class="px-4 py-2 h-[72px] text-center border-t border-gray-300 text-xs md:text-sm">No Data Found</td>
            </tr>
            @endif

            @foreach ($tableData as $student)
            <tr class="border-t border-gray-300 text-xs md:text-sm {{ $loop->index % 2 === 0 ? 'bg-[#F4F4F4]' : 'bg-white' }}">
                <td class="py-5 px-4" rowspan="{{ count($student['records']) }}">{{ $student['name'] }}</td>
                <td class="py-5 px-4">{{ $student['records'][0]['attendance'] }}</td>
                <td class="py-5 px-4">{{ $student['records'][0]['participation'] }}</td>
                <td class="py-5 px-4">{{ $student['records'][0]['behavior'] }}</td>
                <td class="py-5 px-4">{{ $student['records'][0]['homework'] }}</td>
                <td class="py-5 px-4">{{ $student['records'][0]['final_project'] }}</td>
            </tr>

            @foreach (array_slice($student['records'], 1) as $record)
            <tr class="border-t border-gray-300 text-xs md:text-sm {{ $loop->parent->index % 2 === 0 ? 'bg-[#F4F4F4]' : 'bg-white' }}">
                <td class="py-5 px-4">{{ $record['attendance'] }}</td>
                <td class="py-5 px-4">{{ $record['participation'] }}</td>
                <td class="py-5 px-4">{{ $record['behavior'] }}</td>
                <td class="py-5 px-4">{{ $record['homework'] }}</td>
                <td class="py-5 px-4">{{ $record['final_project'] }}</td>
            </tr>
            @endforeach

            @endforeach
        </tbody>
    </table>
</div>
