<div>
    
    <div class="p-4 flex justify-between ">

    <div class="p-2 flex items-center">
        <i class="fa-solid fa-house mx-2"></i>
        @foreach ($paths as $item)
        <span class="mx-2 text-[#D0D5DD]">/</span> 
        <a href="{{ route($item['url']) }}" class="mx-2 cursor-pointer">{{ $item['name'] }}</a>
    @endforeach
    </div>
    
    <div >
        <button type="submit" class="bg-[#2C9A58] text-white px-4 py-2 rounded-md">Submit</button>
    </div>
    
    </div>

    <!-- Form Start -->
    <form  method="POST" enctype="multipart/form-data">
        @csrf <!-- Add CSRF protection -->

        <div class="border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F] mb-3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <!-- Input 1: Point -->
                <div>
                    <label for="value1" class="block mb-1 font-poppins font-semibold text-[14px] leading-[21px] text-[#3A3A3C]">Point</label>
                    <input id="value1" name="point" type="text" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" placeholder="Choose degree" value="{{ old('point') }}">
                </div>
                
                <!-- Input 2: Due Date -->
                <div>
                    <label for="value2" class="block mb-1 font-poppins font-semibold text-[14px] leading-[21px] text-[#3A3A3C]">Due Date</label>
                    <input id="value2" name="due_date" type="date" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" placeholder="Choose Date" value="{{ old('due_date') }}">
                </div>

                <!-- Input 3: Topic -->
                <div>
                    <label for="value3" class="block mb-1 font-poppins font-semibold text-[14px] leading-[21px] text-[#3A3A3C]">Topic</label>
                    <input id="value3" name="topic" type="text" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" placeholder="Choose Topic" value="{{ old('topic') }}">
                </div>

                <!-- Input 4: Assign to -->
                <div>
                    <label for="value4" class="block mb-1 font-poppins font-semibold text-[14px] leading-[21px] text-[#3A3A3C]">Assign to</label>
                    <input id="value4" name="assign_to" type="text" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" placeholder="Choose Classes" value="{{ old('assign_to') }}">
                </div>

                <!-- Input 5: Title -->
                
            </div>
            <!-- Input 6: Description -->
            <div class="pt-4">
                <label for="value5" class="block mb-1 font-poppins font-semibold text-[14px] leading-[21px] text-[#3A3A3C]">Title</label>
                <input id="value5" name="title" type="text" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" placeholder="Choose Title" value="{{ old('title') }}">
            </div>
            <div class="pt-4">
                <label for="value6" class="block mb-1 font-poppins font-semibold text-[14px] leading-[21px] text-[#3A3A3C]">Description</label>
                <input id="value6" name="description" type="text" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" placeholder="Add" value="{{ old('description') }}">
            </div>
        </div>

        <!-- File Upload Section -->
        <div class="w-2/5 mx-auto my-4">
            <label for="file-upload" class="cursor-pointer flex flex-col items-center bg-[#F6F6F6] rounded-xl px-6 py-3 lg:py-5">
                <i class="fa-solid fa-upload"></i>
                <p class="font-normal text-xs md:text-sm">Click here to upload</p>
                <p class="font-normal text-xs md:text-sm text-[#8E8E93]">(JPEG, PNG with max size of 15 MB)</p>
            </label>
            <input id="file-upload" name="file" type="file" class="hidden" accept="image/jpeg, image/png" />
        </div>

    </form>
    <!-- Form End -->
</div>
