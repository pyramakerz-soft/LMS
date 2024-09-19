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
            <button type="submit" class="bg-[#2C9A58] text-white px-4 py-2 rounded-md">Save</button>
        </div>
    </div>

    <!-- Editable Form -->
    <form method="POST" > <!-- Adjust the route accordingly -->
        @csrf <!-- Add CSRF protection -->
        
        <div class="border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F] mb-3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Editable Point -->
                <div>
                    <label class="block mb-1 font-poppins font-semibold text-[14px] leading-[21px] text-[#3A3A3C]">Point</label>
                    <input name="point" type="text" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" value="{{ $data['point'] }}">
                </div>

                <!-- Editable Due Date -->
                <div>
                    <label class="block mb-1 font-poppins font-semibold text-[14px] leading-[21px] text-[#3A3A3C]">Due Date</label>
                    <input name="due_date" type="date" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" value="{{ $data['dueDate'] }}">
                </div>

                <!-- Editable Topic -->
                <div>
                    <label class="block mb-1 font-poppins font-semibold text-[14px] leading-[21px] text-[#3A3A3C]">Topic</label>
                    <input name="topic" type="text" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" value="{{ $data['topic'] }}">
                </div>

                <!-- Editable Assign to -->
                <div>
                    <label class="block mb-1 font-poppins font-semibold text-[14px] leading-[21px] text-[#3A3A3C]">Assign to</label>
                    <input name="assign_to" type="text" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" value="{{ $data['assignTo'] }}">
                </div>

                <!-- Editable Title -->
                <div class="pt-4">
                    <label class="block mb-1 font-poppins font-semibold text-[14px] leading-[21px] text-[#3A3A3C]">Title</label>
                    <input name="title" type="text" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" value="{{ $data['title'] }}">
                </div>

                <!-- Editable Description -->
                <div class="pt-4">
                    <label class="block mb-1 font-poppins font-semibold text-[14px] leading-[21px] text-[#3A3A3C]">Description</label>
                    <textarea name="description" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base">{{ $data['description'] }}</textarea>
                </div>
            </div>

            <!-- File Upload Section -->
            <div class="w-2/5 mx-auto my-4">
                <label for="file-upload" class="cursor-pointer flex flex-col items-center bg-[#F6F6F6] rounded-xl px-6 py-3 lg:py-5">
                    <i class="fa-solid fa-upload"></i>
                    <input id="file-upload" name="file" type="file" class="hidden" accept="image/jpeg, image/png" />
                    <p class="font-normal text-xs md:text-sm">Upload File</p>
                </label>
                @if($data['uploadedFileName'])
                    <p class="font-normal text-xs md:text-sm">Uploaded File: {{ $data['uploadedFileName'] }}</p>
                @endif
            </div>
        </div>
    </form>
</div>
