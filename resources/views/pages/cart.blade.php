@extends('layouts.app')
@section('title', "Panier")
@section('content')
    <div class="container mt-lg-5 mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card mt-5">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('info'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div>
                            <h3 class="mt-0 text-center product-single-title">Panier </h3>
                        </div>
                        @if(!empty($items))
                        <div class="row">
                            <div class="col-lg-8">
                                <form action="{{route('form.update.cart')}}" method="post" id="form-cart">
                                    @csrf
                                <div class="table-responsive">
                                    <table class="table table-borderless table-nowrap table-centered mb-0">
                                        <thead class="table-light">
                                        <tr>
                                            <th>Designation</th>
                                            <th>Prix</th>
                                            <th>Quantité</th>
                                            <th>Total</th>
                                            <th style="width: 50px;"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($items as $item)
                                            <tr>
                                                <td>
                                                    @if($item['image'])
                                                    <img src="{{route('image', ['size' => 'cart', 'image' => $item['image']])}}" alt="contact-img"
                                                         title="contact-img" class="rounded me-3" height="40" />
                                                    @endif
                                                    <p class="m-0 d-inline-block align-middle font-16">
                                                        <a target="_blank" href="{{App\Services\ProductHandler::getProductUrl($item['id_product'], $item['id_attribute'])}}"
                                                           class="text-body">{{\Illuminate\Support\Str::limit($item['product_name'], 25, '...')}}</a>
                                                        <br>
                                                        <small class="me-2"><b></b> {{$item['name']}} </small>
                                                    </p>
                                                </td>
                                                <td>
                                                    {{$item['price']}} MGA
                                                </td>
                                                <td>
                                                    <input type="number" min="1"
                                                           value="{{$item['quantity']}}" onchange="document.querySelector('#form-cart').submit()"
                                                           name="product_attribute[{{$item['id']}}][quantity]"
                                                           class="form-control"
                                                           placeholder="Qty" style="width: 90px;">
                                                </td>
                                                <td style="letter-spacing: 0.105882352941176vw;">
                                                    {{$item['price'] * $item['quantity']}}MGA
                                                </td>
                                                <td>
                                                    <a href="{{route('cart.remove.item', ['id_item' => $item['id']])}}" class="action-icon mt-2">
                                                        <i class="material-icons-outlined">close</i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive-->
                                </form>
                                <!-- action buttons-->
                                <div class="row mt-4">
                                    <div class="col-6">
                                        <a href="{{route('home')}}"
                                           class="btn text-muted btn-link d-inline-flex">
                                            <i class="material-symbols-outlined">keyboard_backspace</i> <span class="ms-1">Retour à la boutique</span> </a>
                                    </div> <!-- end col -->
                                    <div class="col-6">
                                        <div class="text-sm-end">
                                            <a href="{{route('index.checkout')}}" class="lg-btn btn-link text-dark fw-bold">
                                                <i class="mdi mdi-cart-plus me-1"></i> Continuer </a>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row-->

                            </div>
                            <!-- end col -->

                            <div class="col-lg-4">
                                <div class="border p-3 mt-4 mt-lg-0 rounded">
                                    <h4 class="header-title mb-3">Récapitulatif de la commande</h4>

                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <tbody>
                                            <tr>
                                                <td>Sous-total :</td>
                                                <td style="letter-spacing: 0.105882352941176vw;">{{$total}} MGA</td>
                                            </tr>
                                            <tr>
                                                <th>Total :</th>
                                                <th style="letter-spacing: 0.105882352941176vw;">{{$total}} MGA</th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end table-responsive -->
                                </div>


                            </div> <!-- end col -->

                        </div> <!-- end row -->
                            @else
                            Panier vide
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
