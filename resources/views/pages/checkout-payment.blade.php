@extends('layouts.app')
@section('title', 'Information de paiement')
@section('content')
    <div class="container mt-lg-5 mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-none">
                    <div class="card-body">
                        <div>
                            <h3 class="mt-0 text-center product-single-title">Information de paiement</h3>
                        </div>

                        <!-- Checkout Steps -->
                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                            <li class="nav-item">
                                <a href="{{route('index.checkout')}}" class="nav-link rounded-0 ">
                                    <span class="d-block">Expédition</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#payment-information" class="nav-link rounded-0 active">
                                    <span class="d-block">Paiement</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Steps Information -->
                        <div class="tab-content">

                            <!-- Payment Content-->
                            <div class="tab-pane show active" id="payment-information">
                                <form action="{{route('confirm.checkout')}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <h4 class="mt-2">Sélection de paiement</h4>
                                            <p class="text-muted mb-4">Selectionner un moyen de paiement disponible</p>
                                            <!-- Cash on Delivery box-->
                                            <div class="border p-3 mb-3 rounded">
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <div class="form-check">
                                                            <input type="radio" id="BillingOptRadio4"
                                                                   name="paymentOption" value="delivery" checked class="form-check-input">
                                                            <label class="form-check-label font-16 fw-bold"
                                                                   for="BillingOptRadio4">Paiement à la livraison</label>
                                                        </div>
                                                        <p class="mb-0 ps-3 pt-1">Payez en espèces lors de la livraison de votre commande.</p>
                                                    </div>
                                                    <div class="col-sm-4 text-sm-end mt-3 mt-sm-0">
                                                        <span class="material-symbols-outlined" style="font-size: 5vw">local_shipping</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end Cash on Delivery box-->
                                            <div class="row mt-4">
                                                <div class="col-sm-6">
                                                </div> <!-- end col -->
                                                <div class="col-sm-6">
                                                    <div class="text-sm-end">
                                                        <button type="submit" class="lg-btn btn-link text-dark fw-bold">
                                                            <i class="mdi mdi-cash-multiple me-1"></i> Complétez la commande
                                                        </button>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row-->
                                        </div> <!-- end col -->
                                        <div class="col-lg-5">
                                            <div class="border p-3 mt-4 mt-lg-0 rounded">
                                                <h4 class="header-title mb-3">Récapitulatif de la commande</h4>
                                                <div class="table-responsive">
                                                    <table class="table table-centered mb-0">
                                                        <tbody>
                                                        @foreach($items as $item)
                                                            <tr>
                                                                <td>
                                                                    <img src="{{route("image", ['size' => 'cart', 'image' => $item['image']])}}"
                                                                         alt="contact-img"
                                                                         title="contact-img" class="rounded me-2"
                                                                         height="48">
                                                                    <p class="m-0 d-inline-block align-middle">
                                                                        <a href="#"
                                                                           class="text-body fw-semibold">{{$item['product_name']}}</a>
                                                                        <br>
                                                                        <small class="text-muted">{{$item['name']}}</small><br>
                                                                        <small style="letter-spacing: 0.105882352941176vw;">{{$item['quantity']}} x {{$item['price']}}MGA</small>
                                                                    </p>
                                                                </td>
                                                                <td class="text-end" style="letter-spacing: 0.105882352941176vw;">
                                                                    {{$item['quantity'] * $item['price']}}MGA
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                        <tr class="text-end">
                                                            <td>
                                                                <h6 class="m-0">Sous-total:</h6>
                                                            </td>
                                                            <td class="text-end" style="letter-spacing: 0.105882352941176vw;">
                                                                {{$total}}MGA
                                                            </td>
                                                        </tr>
                                                        <tr class="text-end">
                                                            <td>
                                                                <h5 class="m-0">Total:</h5>
                                                            </td>
                                                            <td class="text-end fw-semibold " style="letter-spacing: 0.105882352941176vw;">
                                                                {{$total}}MGA
                                                            </td>
                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                    <div class="alert alert-warning mt-3" role="alert">
                                                        Le coût de livraison depend de l'adresse. Il est possible qu'il y a un montant supplementaire
                                                    </div>
                                                </div>
                                                <!-- end table-responsive -->
                                            </div> <!-- end .border-->
                                        </div> <!-- end col -->
                                    </div> <!-- end row-->
                                </form>
                            </div>
                            <!-- End Payment Information Content-->

                        </div> <!-- end tab content-->

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row-->
    </div>
@endsection