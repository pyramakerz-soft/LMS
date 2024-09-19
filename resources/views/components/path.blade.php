<div class="p-2">
    <i class="fa-solid fa-house mx-2"></i>
    @foreach ($paths as $item)
        <span class="mx-2">/</span> 
        <span class="mx-2">{{ $item }}</span>
    @endforeach
</div>
