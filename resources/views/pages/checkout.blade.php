@extends('layouts.app')
@section('title', 'Vérification de commande')
@section('content')
    <div class="container mt-lg-5 mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-none mt-5">
                    <div class="card-body ">
                        <div>
                            <h3 class="mt-0 text-center product-single-title">Vérification de commande </h3>
                        </div>

                        <!-- Checkout Steps -->
                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#shipping-information" class="nav-link rounded-0 active">
                                    <i class="mdi mdi-truck-fast font-18"></i>
                                    <span class="d-block">Expédition</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#payment-information" class="nav-link rounded-0">
                                    <i class="mdi mdi-cash-multiple font-18"></i>
                                    <span class="d-block">Paiement</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Steps Information -->
                        <div class="tab-content">

                            <!-- Shipping Content-->
                            <div class="tab-pane show active" id="shipping-information">
                                <div class="row">
                                    <div class="col-lg-7">
                                        @if($billings->count() > 0)
                                            <form method="post" action="{{route('confirm.address.checkout')}}">
                                                @csrf
                                                <h4 class="mt-2">Adresse enregistrée</h4>
                                                <p class="text-muted mb-3">Remplissez le formulaire ci-dessous afin de vous envoyer la facture de la commande.</p>
                                                <div class="row">
                                                    @foreach($billings as $index => $billing)
                                                        <div class="col-md-6">
                                                            <div class="border p-3 rounded mb-3 mb-md-0">
                                                                <address class="mb-0 address-lg">
                                                                    <div class="form-check">
                                                                        <input type="radio" id="customRadio1"
                                                                               name="billing_address"
                                                                               class="form-check-input" value="{{$billing->id_billing}}"
                                                                               @if($index ==0)checked="" @endif>
                                                                        <label class="form-check-label font-16 fw-bold"
                                                                               for="customRadio1">Adresse {{$index+1}}</label>
                                                                    </div>
                                                                    <br>
                                                                    <span class="fw-semibold">{{$billing->first_name}} {{$billing->last_name}}</span>
                                                                    <br>
                                                                    {{$billing->address}}<br> {{$billing->city}}
                                                                    , {{$billing->zipcode}}<br>
                                                                    {{$billing->region}}<br>
                                                                    <abbr title="Phone">P:</abbr> {{$billing->phone}}
                                                                    <br>
                                                                </address>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-sm-6"></div>
                                                    <div class="col-sm-6">
                                                        <div class="text-sm-end">
                                                            <button type="submit"
                                                               class="d-inline-flex lg-btn">Continuer vers le paiement
                                                            </button>
                                                        </div>
                                                    </div> <!-- end col -->
                                                </div> <!-- end row -->
                                            </form>
                                        @endif

                                        <!-- end row-->

                                        <h4 class="mt-4">Ajouter une address</h4>

                                        <p class="text-muted mb-4">
                                            Remplissez le formulaire ci-dessous afin que nous puissions vous envoyer la facture de la commande.
                                        </p>

                                        <form action="{{route('create.shipping.customer')}}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="new-adr-first-name"
                                                               class="form-label">Nom <span class="text-danger">*</span></label>
                                                        <input class="form-control" required name="first_name" type="text"
                                                               placeholder="Votre nom"
                                                               id="new-adr-first-name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="new-adr-last-name"
                                                               class="form-label">Prénom <span class="text-danger">*</span></label>
                                                        <input class="form-control" required name="last_name" type="text"
                                                               placeholder="Votre prénom"
                                                               id="new-adr-last-name">
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="new-adr-email-address" class="form-label">Adresse
                                                            email </label>
                                                        <input class="form-control" name="email" type="email"
                                                               placeholder="Adresse email"
                                                               id="new-adr-email-address">
                                                        <small class="text-muted">Ce champ n'est pas obligatoire</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="new-adr-phone" class="form-label">Numéro de
                                                            téléphone <span class="text-danger">*</span></label>
                                                        <input class="form-control" name="phone" required type="text"
                                                               placeholder="xxx xx xxx xx" id="new-adr-phone">
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="new-adr-address"
                                                               class="form-label">Address <span class="text-danger">*</span></label>
                                                        <input class="form-control" name="address" required type="text"
                                                               placeholder="Enter full address"
                                                               id="new-adr-address">
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="new-adr-town-city"
                                                               class="form-label">Ville <span class="text-danger">*</span></label>
                                                        <input class="form-control" name="city" required type="text"
                                                               placeholder="Ex: Analakely"
                                                               id="new-adr-town-city">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="new-adr-zip-postal" class="form-label">Code
                                                            postal</label>
                                                        <input class="form-control" name="zipcode" type="text"
                                                               placeholder="xxx"
                                                               id="new-adr-zip-postal">
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                            <div class="row mt-4">
                                                <div class="col-sm-6">
                                                    <button type="submit"
                                                            class="btn d-none d-sm-inline-block btn-outline-dark fw-semibold">
                                                        Enregistrer
                                                    </button>
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->

                                            <!--                                                <div class="row">
                                                                                                <div class="col-12">
                                                                                                    <div class="mb-3">
                                                                                                        <label class="form-label">Zone</label>
                                                                                                        <select data-toggle="select2" title="Country">
                                                                                                            <option value="0">Select Country</option>
                                                                                                            <option value="AF">Afghanistan</option>
                                                                                                            <option value="AL">Albania</option>
                                                                                                            <option value="AT">Austria</option>
                                                                                                            <option value="AZ">Azerbaijan</option>
                                                                                                            <option value="BS">Bahamas</option>
                                                                                                            <option value="BH">Bahrain</option>
                                                                                                            <option value="BD">Bangladesh</option>
                                                                                                            <option value="DO">Dominican Republic</option>
                                                                                                            <option value="EC">Ecuador</option>
                                                                                                            <option value="LS">Lesotho</option>
                                                                                                            <option value="LR">Liberia</option>
                                                                                                            <option value="LY">Libyan Arab Jamahiriya</option>
                                                                                                            <option value="LI">Liechtenstein</option>
                                                                                                            <option value="LT">Lithuania</option>
                                                                                                            <option value="LU">Luxembourg</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div> -->

                                            <div class="row mt-4">
                                                <div class="col-sm-6">
                                                    <a href="{{route('home')}}"
                                                       class="btn text-muted btn-link d-inline-flex">
                                                        <i class="material-symbols-outlined">keyboard_backspace</i> <span class="ms-1">Retour à la boutique</span> </a>
                                                </div> <!-- end col -->
                                            </div>
                                        </form>
                                    </div>
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
                            </div>
                            <!-- End Shipping Information Content-->

                        </div> <!-- end tab content-->

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row-->
    </div>
@endsection