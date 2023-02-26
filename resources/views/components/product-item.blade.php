<div class="product mb-4">
    <form method="post" class="form-product-item" action="{{route('update.cart')}}">
        @csrf
        <a href="{{$url}}" class="d-inline-block">
            <div class="product-item-image-content">
                <img class="product__img img-fluid" src="{{route('image', ['size' => 'medium', 'image' => $product->image])}}" alt="{{$product->name}}">
                <button class="product__add-to-cart" type="submit"> <span class="material-icons-outlined font-14" style="margin-right: 5px">add</span> Ajouter au panier</button>
            </div>
        </a>
        <div class="product__content">
            <h3 class="header product__title">
                <a href="{{$url}}" >{{$product->name}}</a>
            </h3>

            <div class="text-muted mb-2 text-center">{{$attribute->name}}</div>
            <div class="price-wrapper mb-2">
                <span class="product__price d-block">{{$attribute->price}} MGA</span>
            </div>

            <input type="hidden" name="id" value="{{$product->id_product}}">
            <input type="hidden" name="product_attribute_id" value="{{$attribute->product_attribute_id}}">
            <input type="hidden" name="quantity" value="1">
        </div>
    </form>

</div>

<style>
    .product__content .product__title {
        text-transform: uppercase;
        letter-spacing: 0.141176470588235vw;
        font-size: 25px;
        text-align: center;
        font-weight: 600;
    }
    .product__content .product__title a, form.form-product-item .product__price {
        color: black;
    }
.product-item-image-content {
  position: relative;
  z-index: 1;
}

  .product-item-image-content .product__add-to-cart {
      display: none;
      position: absolute;
      left: calc(100% - 320px);
      bottom: 3em;
      z-index: 99;
      padding: 10px 20px;
    }


    .product-item-image-content:hover .product__add-to-cart {
      display: flex;
      align-content: stretch;
      justify-content: center;
      align-items: center;
      flex-direction: row;
      flex-wrap: nowrap;
    }

    .product-item-image-content .product__add-to-cart:hover {
        background-color: #ffa33f;
    }

    form.form-product-item .product__price {
      text-align: center;
      font-weight: 500;
    font-size: 20px;
    line-height: 30px;
    letter-spacing: 0.8px;
    }

    form.form-product-item:hover .product-item-image-content {
        position: relative;
    }

    form.form-product-item:hover .product-item-image-content:before {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
    }
</style>
