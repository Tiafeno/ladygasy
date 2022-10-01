@extends('layouts.app')
@section('content')
    <div class="container mt-lg-5 mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h3 class="mt-0 text-center product-single-title">{{ $product->name }} </h3>
                        </div>
                        <div class="row">
                            <div class="col-lg-5">
                                <!-- Product image -->
                                <a href="javascript: void(0);" class="text-center d-block mb-4">
                                    <img src="{{ $product->getImage() }}" class="img-fluid" style="max-width: 280px;"
                                        alt="Product-img">
                                </a>

                                <div class="d-lg-flex d-none justify-content-center">
                                    <a href="javascript: void(0);">
                                        <img src="{{ $product->getImage('cart') }}" class="img-fluid img-thumbnail p-2"
                                            style="max-width: 75px;" alt="Product-img">
                                    </a>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-lg-7">
                                <form class="ps-lg-4" action="{{route('update.cart')}}" method="post">
                                @csrf
                                    <!-- Product title -->
                                    <div class="mb-2">
                                        <h4><span class="badge badge-success-lighten">Disponible</span></h4>
                                    </div>

                                    <div class="mb-3">
                                        {!!  $product->description !!}
                                    </div>
                                    <!-- Product stock -->

                                    <div class="mb-3">
                                        <h3 class="product__price--item"><span id="single-product-price">{{ $price }}</span> MGA</h3>
                                    </div>

                                    @if ($attributes)
                                        <div class="row">
                                            <div class="col-xs-12 col-md-6">
                                                <select name="product_attribute_id" class="form-select single-product-attribute" name="attribute">
                                                    @foreach ($attributes as $attribute)
                                                        <option
                                                        data-price="{{$attribute->price}}"
                                                        data-quantity="{{$attribute->quantity}}"
                                                        @if ($attribute->id_product_attribute == $id_attribute) selected @endif
                                                            value="{{ $attribute->id_product_attribute }}">
                                                            {{ $attribute->name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    @endempty


                                    <!-- Quantity -->
                                    <div class="mt-4">
                                        <h6 class="font-14">Quantity</h6>
                                        <div class="d-flex">
                                            <input type="hidden" id="single-unit-price" name="unit-price"
                                                value="{{ $price }}">
                                            <input type="hidden" name="id" value="{{$product->id_product}}">

                                            <input type="number" min="1" value="1" name="quantity" class="form-control"
                                                id="single-product-quantity" placeholder="Qty" style="width: 90px;">
                                            <button type="submit" class=" ms-2 product__add-to-cart"><i
                                                    class="mdi mdi-cart me-1"></i> Ajouter au panier</button>
                                        </div>
                                    </div>

                                    <!-- Product description -->
                            </form>
                        </div> <!-- end col -->
                    </div> <!-- end row-->




                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
</div>
@endsection
