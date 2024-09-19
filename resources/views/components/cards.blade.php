<div class="flex flex-wrap">
  @foreach ($cards as $card)
  <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
    <div class="h-[350px] bg-white shadow-md border border-slate-200 rounded-md">
      <a class="cursor-pointer" href="{{ route($card['url']) }}">
        <img src="https://images.unsplash.com/photo-1540553016722-983e48a2cd10?ixlib=rb-1.2.1&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=800&amp;q=80"
        alt="card-image"
        class="object-cover w-full h-[80%] rounded-md">
        <p class="py-5 px-2 text-slate-800 text-2xl font-semibold">
          {{ $card["title"] }}
        </p>
      </a>
    </div>
  </div>
  @endforeach
</div>