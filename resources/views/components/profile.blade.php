<div class="container flex items-center justify-between p-4 bg-[#2E3646]">
    <div class="flex items-center">
        <!-- Avatar -->
        <div>
            <img class="w-[100px] h-[100px] rounded-full" alt="avatar1" src="https://mdbcdn.b-cdn.net/img/new/avatars/9.webp" />
        </div>

        <!-- Name and Class Info -->
        <div class="ml-3">
            <div class="text-white font-inter font-semibold text-[20px] leading-[32px] tracking-[-0.13px]">
                {{$name}}
            </div>
            <div class="text-white font-inter font-bold text-[14.98px] leading-[22.47px] tracking-[-0.09px]">
                {{$subText}}</div>
        </div>
    </div>

    <!-- Bell Icon -->
    <div>
        <i class="fa-solid fa-bell text-white text-[24px]"></i>
    </div>
</div>