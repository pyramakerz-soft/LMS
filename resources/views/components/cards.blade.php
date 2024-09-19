<div class="flex flex-wrap">
  @foreach ($cards as $card)
  <div class="w-full sm:w-1/2 lg:w-1/4 px-3 mb-6">
    <!-- Card Image -->
    <div class="flex flex-col bg-white shadow-md border border-slate-200 rounded-lg">
      <div class="relative w-[241px] h-[276px] m-2.5 overflow-hidden rounded-md">
        <img src="https://images.unsplash.com/photo-1540553016722-983e48a2cd10?ixlib=rb-1.2.1&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=800&amp;q=80"
             alt="card-image"
             class="object-cover w-full h-full rounded-md">
      </div>
      <!-- Card Content -->
      <div class="p-4">
        <h6 class="mb-2 text-slate-800 text-xl font-semibold text-center">
          {{ $card["title"] }}
        </h6>
      </div>
    </div>
  </div>
  @endforeach
</div>