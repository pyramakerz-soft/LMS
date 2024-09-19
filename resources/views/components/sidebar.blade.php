<div class="bg-[#17253E] min-h-[100vh] h-full border-r-[1.33px] border-[#2E3545]">
    <div class="">
        <div class="px-3 md:px-5 py-3 md:py-4 bg-[#2E3646] flex justify-center">
            <img src="{{ asset('images/Paragraph container.png') }}" class="w-2/3 md:w-[90%]" />
        </div>
    </div>

    <nav class="flex flex-col text-[#A5ACBA]">
        <p class="text-base md:text-lg font-semibold px-9 mb-4 uppercase">Main Menu</p>

        @foreach ($menuItems as $menuItem)
            <div class="text_Style text-lg md:text-xl font-semibold px-9 py-3 md:py-5 flex items-center space-x-4 cursor-pointer"
                {{-- [ngClass]="{ active: activeIndex === i }"
            (click)="setActiveIndex(i); item.label === 'Sign Out' ? signOut() : null"
            [routerLink]="item.label === 'Sign Out' ? null : item.route" --}}>
                <i class="{{ $menuItem['icon'] }}"></i>
                <a class="no-underline ml-3">{{ $menuItem['label'] }}</a>
            </div>
        @endforeach
        <div
            class="text_Style text-lg md:text-xl font-semibold px-9 py-3 md:py-5 flex items-center space-x-4 cursor-pointer">
            <i class="fi fi-bs-sign-out-alt transform rotate-180"></i>
            <a class="no-underline ml-3">Sign Out</a>
        </div>
    </nav>
</div>
