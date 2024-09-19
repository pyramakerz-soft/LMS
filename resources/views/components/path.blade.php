<div class="p-2 text-[#667085] my-8">
    <i class="fa-solid fa-house mx-2"></i>
    @foreach ($paths as $item)
        <span class="mx-2 text-[#D0D5DD]">/</span> 
        <span class="mx-2">{{ $item }}</span>
    @endforeach
</div>
