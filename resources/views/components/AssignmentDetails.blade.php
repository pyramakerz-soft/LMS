<div>
    <div class="p-4 flex justify-between">
        <div class="p-2 flex items-center">
            <i class="fa-solid fa-house mx-2"></i>
            @foreach ($paths as $item)
            <span class="mx-2 text-[#D0D5DD]">/</span> 
            <a href="{{ route($item['url']) }}" class="mx-2 cursor-pointer">{{ $item['name'] }}</a>
        @endforeach
        </div>
        
        <div>
            <button type="submit" class="bg-[#2C9A58] text-white px-4 py-2 rounded-md">Edit</button>
        </div>
    </div>

    <!-- Display Information -->
    <div class="border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F] mb-3">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Display Point -->
            <div>
                <label class="block mb-1 font-poppins font-semibold text-[14px] leading-[21px] text-[#3A3A3C]">Point</label>
                <span class="block border border-[#E5E5EA] rounded-lg p-2 md:p-4 text-xs md:text-base bg-gray-100">{{ $data['point'] }}</span>
            </div>

            <!-- Display Due Date -->
            <div>
                <label class="block mb-1 font-poppins font-semibold text-[14px] leading-[21px] text-[#3A3A3C]">Due Date</label>
                <span class="block border border-[#E5E5EA] rounded-lg p-2 md:p-4 text-xs md:text-base bg-gray-100">{{ $data['dueDate'] }}</span>
            </div>

            <!-- Display Topic -->
            <div>
                <label class="block mb-1 font-poppins font-semibold text-[14px] leading-[21px] text-[#3A3A3C]">Topic</label>
                <span class="block border border-[#E5E5EA] rounded-lg p-2 md:p-4 text-xs md:text-base bg-gray-100">{{ $data['topic'] }}</span>
            </div>

            <!-- Display Assign to -->
            <div>
                <label class="block mb-1 font-poppins font-semibold text-[14px] leading-[21px] text-[#3A3A3C]">Assign to</label>
                <span class="block border border-[#E5E5EA] rounded-lg p-2 md:p-4 text-xs md:text-base bg-gray-100"> {{ $data['assignTo'] }}</span>
            </div>

            <!-- Display Title -->
            <div class="pt-4">
                <label class="block mb-1 font-poppins font-semibold text-[14px] leading-[21px] text-[#3A3A3C]">Title</label>
                <span class="block border border-[#E5E5EA] rounded-lg p-2 md:p-4 text-xs md:text-base bg-gray-100">{{ $data['title'] }}</span>
            </div>

            <!-- Display Description -->
            <div class="pt-4">
                <label class="block mb-1 font-poppins font-semibold text-[14px] leading-[21px] text-[#3A3A3C]">Description</label>
                <span class="block border border-[#E5E5EA] rounded-lg p-2 md:p-4 text-xs md:text-base bg-gray-100">{{ $data['description'] }}</span>
            </div>
        </div>

        <!-- File Upload Section -->
        <div class="w-2/5 mx-auto my-4">
            <label for="file-upload" class="cursor-pointer flex flex-col items-center bg-[#F6F6F6] rounded-xl px-6 py-3 lg:py-5">
                <i class="fa-solid fa-upload"></i>
                <p class="font-normal text-xs md:text-sm">Uploaded File: {{ $data['uploadedFileName'] }}</p>
            </label>
        </div>
    </div>
</div>
