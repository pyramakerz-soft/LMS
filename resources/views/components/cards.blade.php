<div class="d-flex align-items-center p-2">
    @foreach ($cards as $item)
    <div class="card me-3 mb-3" style="width: 241px; height: 180px; border: 1px solid #000; background-color: #F6F6F6;">
        <div class="card-body text-center">
          <h5 class="card-text">{{ $item }}</h5>
        </div>
    </div>
    @endforeach
</div>
