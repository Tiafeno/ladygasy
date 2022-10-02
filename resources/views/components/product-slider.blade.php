<ul class="nav nav-tabs nav-bordered mb-3" style="
margin: 0 auto;
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    align-content: center;
    justify-content: center;">
    @foreach ($data as $index => $item)
        <li class="nav-item">
        <a href="#{{$item['slug']}}-b2" data-bs-toggle="tab" aria-expanded="true" class="nav-link @if($index == 0) active @endif text-uppercase">
            <i class="mdi mdi-account-circle d-md-none d-block"></i>
            <span class="d-none d-md-block">{{$item['name']}}</span>
        </a>
    </li>
    @endforeach

</ul>

<div class="tab-content">
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
          <a href="{{$item['url']}}" class="btn lg-btn">Voir +</a>
        </div>
      </div>
    @endforeach
</div>
