<div>
    
    <div class="my-8 flex justify-between ">
        <div class="p-2 text-[#667085]">
            <i class="fa-solid fa-house mx-2"></i>
            @foreach ($paths as $item)
                <span class="mx-2 text-[#D0D5DD]">/</span> 
                <a href="{{ route($item['url']) }}" class="mx-2 cursor-pointer">{{ $item['name'] }}</a>
            @endforeach
        </div>
        
        <div >
            <button type="submit" class="bg-[#2C9A58] text-white rounded-md px-5 py-3">Submit</button>
        </div>
    </div>

    <form  method="POST" enctype="multipart/form-data">
        @csrf
        <div class="border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F] mb-3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <div>
                    <label for="value1" class="block mb-1 font-semibold text-sm text-[#3A3A3C]">Point</label>
                    <input id="value1" name="point" type="text" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" placeholder="Choose degree" value="{{ old('point') }}">
                </div>
                
                <div>
                    <label for="value2" class="block mb-1 font-semibold text-sm text-[#3A3A3C]">Due Date</label>
                    <input id="value2" name="due_date" type="date" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" placeholder="Choose Date" value="{{ old('due_date') }}">
                </div>

                <div>
                    <label for="value3" class="block mb-1 font-semibold text-sm text-[#3A3A3C]">Topic</label>
                    <input id="value3" name="topic" type="text" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" placeholder="Choose Topic" value="{{ old('topic') }}">
                </div>

                <div>
                    <label for="value4" class="block mb-1 font-semibold text-sm text-[#3A3A3C]">Assign to</label>
                    <input id="value4" name="assign_to" type="text" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" placeholder="Choose Classes" value="{{ old('assign_to') }}">
                </div>
                
            </div>
            <div class="pt-4">
                <label for="value5" class="block mb-1 font-semibold text-sm text-[#3A3A3C]">Title</label>
                <input id="value5" name="title" type="text" class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" placeholder="Choose Title" value="{{ old('title') }}">
            </div>
            <div class="pt-4">
                <label for="value6" class="block mb-1 font-semibold text-sm text-[#3A3A3C]">Description</label>
                <input id="value6" name="description" type="text" class=" min-h-24 border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" placeholder="Add" value="{{ old('description') }}">
            </div>
        </div>

        <div class="border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F] mt-7">
            <div class="w-full md:w-2/5 mx-auto">
                <label for="file-upload" class="cursor-pointer flex flex-col items-center border border-dashed border-[#CACACA] rounded-xl px-6 py-3 lg:py-5">
                    <i class="fa-solid fa-upload text-[#FF7519] bg-[#F5F5F5] rounded-full p-3"></i>
                    <p class="my-2"><span class="text-[#FF7519]">Click to Upload</span> or drag and drop</p>
                    <p> (Max. File size: 25 MB) </p>
                </label>
                <input id="file-upload" name="file-upload" type="file" class="hidden" />
            </div>
        </div>
    </form>
</div>
