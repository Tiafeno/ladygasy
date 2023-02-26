<ul class="mb-3 nav justify-content-center nav-tabs nav-bordered">
    @foreach ($data as $index => $item)
      <li class="nav-item">
        <a href="#{{$item['slug']}}-b2" data-bs-toggle="tab" aria-expanded="true"
           class="btn text-dark font-20 me-2 @if($index == 0) active @endif text-uppercase">
            <i class="mdi mdi-account-circle d-md-none d-block"></i>
            <span class=" d-md-block">{{$item['name']}}</span>
        </a>
      </li>
    @endforeach

</ul>

<div class="tab-content" style="min-height: 70vh">
    @foreach ($data as $index => $item)
      <div class="tab-pane @if($index == 0) show active @endif" id="{{$item['slug']}}-b2">
        <div class="row">
        @foreach ($item['products'] as $product_id)
          <div class="col-md-4 col-xs-12">
            <x-product-item :product-id="$product_id"></x-product-item>
          </div>
        @endforeach
        </div>
        <div class="row justify-content-center">
          <a href="{{$item['url']}}" style="width: inherit" class="btn lg-btn d-block">Voir +</a>
        </div>
      </div>
    @endforeach
</div>
