
<div class="dropdown mt-1" >
    <a class="arrow-none dropdown-toggle text-dark" data-bs-toggle="dropdown" href="#" aria-haspopup="true"
       aria-expanded="false">
        @if(!empty($items))
        <span class="badge bg-danger text-white" style="position: absolute;left: -20px;">{{count($items)}}</span>
        @endif
        <span class="material-icons-outlined">shopping_cart</span>
    </a>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg" style="border: 4px solid #ffd199;">
        <!-- item-->
        <div class="dropdown-item noti-title px-3">
            <h5 class="m-0">
                Panier
            </h5>
        </div>

        <div class="px-3" style="max-height: 400px;" data-simplebar>
            <!-- item-->
            @foreach($items as $item)
            <div class="dropdown-item p-0 notify-item card read-noti shadow-none mb-2">
                <div class="card-body px-0 pt-0 pb-2">
                    <a href="{{route('cart.remove.item', ['id_item' => $item['id']])}}"
                       class="float-end noti-close-btn text-muted mt-2" title="Supprimer"><span class="material-icons-outlined" style="font-size: 15px">close</span></a>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="{{route("image", ['size' => 'cart', 'image' => $item['image']])}}" width="35px" class="img-thumbnail">
                        </div>
                        <div class="flex-grow-1 text-truncate ms-2">
                            <h5 class="noti-item-title fw-semibold font-14 mb-0">{{$item['product_name']}}
                                </h5>
                            <small class="fw-normal text-muted">{{$item['name']}}</small><br>
                            <small class="noti-item-subtitle text-muted">{{$item['price']}} MGA  x{{$item['quantity']}}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @empty($items)
                Aucun article
            @endempty

            @if(!empty($items))
            <div class="text-center mb-3">
                <div class="row d-flex justify-content-between">
                    <div class="col-12 font-15">
                        <small >SOUS-TOTAL : </small><small class="fw-semibold  ms-3">{{$total}} MGA</small>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- All-->
        @if(!empty($items))
        <a href="{{route('page.cart')}}"
           class="dropdown-item text-center fw-semibold text-uppercase  notify-item border-top border-light py-2">
            Commander
        </a>
        @endif

    </div>
</div>
