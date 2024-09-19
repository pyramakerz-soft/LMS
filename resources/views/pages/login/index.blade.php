@extends('layouts.app')

@section("login")
    <div class="lg:h-[100vh] flex flex-col-reverse lg:flex-row">
        <form action="{{route('login.post')}}" method="POST" class="w-full lg:w-1/3 bg-white flex flex-col justify-center items-center p-12 md:p-20">
            @csrf
            <img src="{{ asset('images/Paragraphcontainer.png') }}" alt="Logo" class="w-[63%]">
            <p class="h5 text-[#111111] py-3">Hello, please sign into your account</p>

            <div class="w-full text-start">
                <label htmlFor="text" class="h-4 font-medium text-[#344054] block mb-1" >
                    Email
                </label>
                <input id="email" name="username" type="text" placeholder="Enter your username" 
                class="h5 w-full bg-white border rounded border-[#D0D5DD] shadow-sm shadow-[#1018280D] h-[22%]  py-[7.5px] px-[10.5px]"   [(ngModel)]="email">
                
                <label htmlFor="pass" class="h-4 font-medium text-[#344054] block mb-1 mt-4"  >
                    Password
                </label>
                <input id="pass" type="password" name="password"
                class="h5 w-full bg-white border rounded border-[#D0D5DD] shadow-sm shadow-[#1018280D] h-[22%] py-[7.5px] px-[10.5px]" [(ngModel)]="password">
            </div>

            <button type="submit" class="mt-4 w-full text-white font-semibold text-xs shadow-sm bg-[#17253E] border border-[#17253E] py-2 rounded-md">Sign in</button>
        </form>

        <div class="w-full lg:w-2/3 bgLinearGradient text-white flex flex-col items-center justify-center p-3 lg:p-0">
            <p class="text-xl md:text-4xl font-bold mb-8">Do more <span class="font-normal">with Pyramakerz</span></p>

            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('images/Layer 2.png') }}" alt="calender" class="w-[83%] mb-6">
            </div>

        </div>
    </div>
@endsection