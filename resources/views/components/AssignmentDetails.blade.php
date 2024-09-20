<div>
    <div class="border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
        <div class="flex flex-col md:flex-row mt-5 flex-wrap">
            <div class="w-full md:w-1/2">
                <label class="block font-semibold text-[14px] leading-[21px] text-[#909090] mb-3">Point</label>
                <span class="text-xs md:text-base text-[#282727]">{{ $data['point'] }}</span>
            </div>

            <hr class="my-5 w-full border border-[#E5E5EA] md:hidden">

            <div class="w-full md:w-1/2">
                <label class="block font-semibold text-[14px] leading-[21px] text-[#909090] mb-3">Due Date</label>
                <span class="text-xs md:text-base text-[#282727]">{{ $data['dueDate'] }}</span>
            </div>

            <hr class="my-5 w-full border border-[#E5E5EA]">

            <div class="w-full md:w-1/2">
                <label class="block font-semibold text-[14px] leading-[21px] text-[#909090] mb-3">Topic</label>
                <span class="text-xs md:text-base text-[#282727]">{{ $data['topic'] }}</span>
            </div>

            <hr class="my-5 w-full border border-[#E5E5EA] md:hidden">

            <div class="w-full md:w-1/2">
                <label class="block font-semibold text-[14px] leading-[21px] text-[#909090] mb-3">Assign to</label>
                @foreach ($data['assignTo'] as $assignedTo)
                    <span class="text-xs md:text-base text-[#282727] bg-[#CEDCFF] rounded-md p-1">{{ $assignedTo }}</span>
                @endforeach 
            </div>

            <hr class="my-5 w-full border border-[#E5E5EA]">

            <div class="w-full md:w-1/2">
                <label class="block font-semibold text-[14px] leading-[21px] text-[#909090] mb-3">Title</label>
                <span class="text-xs md:text-base text-[#282727]">{{ $data['title'] }}</span>
            </div>

            <hr class="my-5 w-full border border-[#E5E5EA]">

            <div class="w-full">
                <label class="block font-semibold text-[14px] leading-[21px] text-[#909090] mb-3">Description</label>
                <span class="text-xs md:text-base text-[#282727]">{{ $data['description'] }}</span>
            </div>
            
            <hr class="my-5 w-full border border-[#E5E5EA]">

            <div class="w-full">
                <label class="block font-semibold text-[14px] leading-[21px] text-[#909090] mb-3">Attach</label>

                <div class="block md:flex flex-wrap gap-4">
                    @foreach ($data['uploadedFileName'] as $media)
                        @if ($media['type'] == 'photo')
                            <img src="{{ $media['url'] }}" alt="photo" class="rounded-lg w-full md:w-[32%] object-cover mb-2 md:mb-0">
                        @elseif ($media['type'] == 'video')
                            <video controls class="rounded-lg w-full md:w-[32%] mb-2 md:mb-0">
                                <source src="{{ $media['url'] }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                    @endforeach
                </div>
                
                <div class="block md:flex flex-wrap gap-4 my-5">
                    @foreach ($data['uploadedFileName'] as $media)
                        @if ($media['type'] == 'pdf')
                            <div class="flex space-x-3 p-5 border rounded-lg w-fit">
                                <i class="fi fi-rr-document"></i>
                                <div>
                                    <p>{{ $media['file_name'] }}</p>
                                    <p class="text-[#989692] text-sm my-1">{{ $media['file_space'] }}</p>
                                    <a href="{{ $media['url'] }}" target="_blank" class="font-semibold text-[#A020F0]">Click to view</a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="w-full">
                    @foreach ($data['uploadedFileName'] as $media)
                        @if ($media['type'] == 'link')
                            <div class="flex space-x-2 items-center my-2">
                                <img src="images/Group.png" alt="link icon">
                                <a href="{{ $media['url'] }}" target="_blank" class="underline text-black font-semibold">{{ $media['url'] }}</a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <div class="border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F] mt-7">
        <div class="w-full md:w-2/5 mx-auto">
            <label for="file-upload" class="cursor-pointer flex flex-col items-center border border-dashed border-[#CACACA] rounded-xl px-6 py-3 lg:py-5">
                <i class="fa-solid fa-upload text-[#FF7519] bg-[#F5F5F5] rounded-full p-3"></i>
                <p class="my-2"><span class="text-[#FF7519]">Click to Upload</span>or drag and drop</p>
                <p> (Max. File size: 25 MB) </p>
            </label>
            <input id="file-upload" name="file-upload" type="file" class="hidden" />
        </div>
    </div>
</div>