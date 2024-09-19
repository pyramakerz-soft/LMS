<div class="rounded-lg flex items-center justify-between py-3 px-6 bg-[#2E3646]">
    <div class="flex items-center space-x-4">
        <div>
            <img class="w-20 h-20 rounded-full" alt="avatar1" src="{{$image}}" />
        </div>

        <div class="ml-3 font-semibold text-white flex flex-col space-y-2">
            <div class="text-xl">
                {{$name}}
            </div>
            <div class="text-sm">
                {{$subText}}</div>
        </div>
    </div>

    <div class="relative">
        <i class="fa-solid fa-bell text-[#FF7519] text-xl"></i>
        <span class="absolute -top-2 -right-2 bg-black border-2 border-white text-white rounded-full text-[10px] px-1 py-0.25">5</span>
    </div>
</div>