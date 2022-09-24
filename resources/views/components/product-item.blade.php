<div class="product">
    <form>
        <a href="#" class="d-inline-block">
            <div>
                <img class="product__img img-fluid" src="{{route('image', ['size' => 'medium', 'image' => $product->image])}}" alt="{{$product->name}}">
            </div>
        </a>
        <div class="product__content">
            <h3 class="header product__title">{{$product->name}}</h3>
            <div class="text-muted ">{{$attribute->name}}</div>
            <div class="price-wrapper">
                <span class="product__price">{{$product->price}}</span>
            </div>
            <button class="product__add-to-cart" type="submit">Add to cart</button>
            <input type="hidden" name="id" value="{{$product->id_product}}">
            <input type="hidden" name="product_attribute_id" value="{{$attribute->attribute_id}}">
            <input type="hidden" name="count" value="1">
        </div>
    </form>

</div>