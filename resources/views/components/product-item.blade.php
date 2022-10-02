<div class="product mb-4">
    <form method="post" class="form-product-item" action="{{route('update.cart')}}">
        @csrf
        <a href="{{$url}}" class="d-inline-block">
            <div class="product-item-image-content">
                <img class="product__img img-fluid" src="{{route('image', ['size' => 'medium', 'image' => $product->image])}}" alt="{{$product->name}}">
            </div>
        </a>
        <div class="product__content">
            <h3 class="header product__title">
                <a href="{{$url}}" >{{$product->name}}</a>
            </h3>

            <div class="text-muted mb-2">{{$attribute->name}}</div>
            <div class="price-wrapper mb-2">
                <span class="product__price">{{$attribute->price}} MGA</span>
            </div>
            <button class="product__add-to-cart" type="submit">Ajouter au panier</button>
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
        font-size: 16px;
        font-weight: 600;
    }
    .product__content .product__title a {
        color: black;
    }

    form.form-product-item:hover .product-item-image-content {
        position: relative;
    }
    form.form-product-item:hover .product-item-image-content:before {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        border: 4px solid #f3c673;
    }
</style>
