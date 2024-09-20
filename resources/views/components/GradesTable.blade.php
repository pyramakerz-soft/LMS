<div class="p-4">

    <div class="mt-5 overflow-x-auto rounded-2xl border border-[#EAECF0]">
        <table class="w-full table-auto bg-[#FFFFFF] text-left text-[#475467] text-lg md:text-xl"> <!-- Increased text size -->
            <thead class="bg-[#F9FAFB] text-lg md:text-xl"> <!-- Increased text size -->
                <tr>
                    <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Name</th>
                    <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Attendance</th>
                    <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Classroom Participation</th>
                    <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Classroom Behavior</th>
                    <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Homework</th>
                    <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Final Project</th>
                </tr>
            </thead>
            <tbody>
                @if(count($tableData) === 0)
                <tr>
                    <td colspan="6" class="px-4 py-4 h-[72px] text-center border-t border-gray-300 text-lg md:text-xl">No Data Found</td> <!-- Increased text size -->
                </tr>
                @endif
    
                @foreach ($tableData as $student)
                <tr class="border-t border-gray-300 text-lg md:text-xl {{ $loop->index % 2 === 0 ? 'bg-[#F4F4F4]' : 'bg-white' }}"> <!-- Increased text size -->
                    <td class="py-5 px-6" rowspan="{{ count($student['records']) }}">
                        <a href="{{ route('teacher.student.grade') }}" class="text-blue-600 hover:underline">
                            {{ $student['name'] }}
                        </a>
                    </td>                    <td class="py-5 px-6">{{ $student['records'][0]['attendance'] }}</td>
                    <td class="py-5 px-6">{{ $student['records'][0]['participation'] }}</td>
                    <td class="py-5 px-6">{{ $student['records'][0]['behavior'] }}</td>
                    <td class="py-5 px-6">{{ $student['records'][0]['homework'] }}</td>
                    <td class="py-5 px-6">{{ $student['records'][0]['final_project'] }}</td>
                </tr>
    
                @foreach (array_slice($student['records'], 1) as $record)
                <tr class="border-t border-gray-300 text-lg md:text-xl {{ $loop->parent->index % 2 === 0 ? 'bg-[#F4F4F4]' : 'bg-white' }}"> <!-- Increased text size -->
                    <td class="py-5 px-6">{{ $record['attendance'] }}</td>
                    <td class="py-5 px-6">{{ $record['participation'] }}</td>
                    <td class="py-5 px-6">{{ $record['behavior'] }}</td>
                    <td class="py-5 px-6">{{ $record['homework'] }}</td>
                    <td class="py-5 px-6">{{ $record['final_project'] }}</td>
                </tr>
                @endforeach
    
                @endforeach
            </tbody>
        </table>
    </div>

</div>
