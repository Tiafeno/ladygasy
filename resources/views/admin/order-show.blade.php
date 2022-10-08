@extends('layouts.admin')
@section('title', "Commande no #".$order->id_order)
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Items from Order #{{$order->id_order}}</h4>

                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Designation</th>
                                        <th>Quantité</th>
                                        <th>Prix HT</th>
                                        <th>Total HT</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->getItems() as $item)
                                        <tr>
                                            <td>{{$item['product_name']}}<br><small class="text-muted">{{$item['attribute_name']}}</small></td>
                                            <td>{{$item['product_quantity']}}</td>
                                            <td>{{$item['product_price']}} MGA</td>
                                            <td>{{$item['product_price'] * $item['product_quantity']}} MGA</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- end table-responsive -->

                        </div>
                    </div>
                </div> <!-- end col -->

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Order Summary</h4>

                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Description</th>
                                        <th>Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Grand Total :</td>
                                        <td>{{$order->getTotal()}} MGA</td>
                                    </tr>
                                    <tr>
                                        <td>Livraison :</td>
                                        <td>{{$order->delivery_cost}} MGA</td>
                                    </tr>
                                    <tr>
                                        <th>Total :</th>
                                        <th>{{$order->getTotal() + $order->delivery_cost}} MGA</th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- end table-responsive -->

                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->


            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Information de livraison</h4>
                            @if(!empty($address))
                            <h5>{{$address['first_name']}} {{$address['last_name']}}</h5>
                            <address class="mb-0 font-14 address-lg">
                                {{$address['address']}}<br>
                                {{$address['city']}}, {{$address['zipcode']}}<br>
                                <abbr title="Mobile">M:</abbr> {{$address['phone']}}
                            </address>
                            @endif
                        </div>
                    </div>
                </div> <!-- end col -->

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Information de paiement</h4>

                            <ul class="list-unstyled mb-0">
                                <li>
                                    <p class="mb-2"><span class="fw-bold me-2">Type de paiement:</span> {{$order->payment}}</p>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div> <!-- end col -->

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Action</h4>

                            <div>
                                <form method="post" action="{{route('update.admin.order', ['id_order' => $order->id_order])}}">
                                    @method('PATCH')
                                    @csrf
                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <div class="form-floating mb-2">
                                                <select class="form-select" id="floatingSelect" name="status" aria-label="Floating label select example">
                                                    @foreach(\App\Models\Orders::status() as $st)
                                                    <option @if($status_code == $st['code']) selected @endif value="{{$st['code']}}">
                                                        {{$st['name']}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <label for="floatingSelect">Statut commande</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control" name="cost" value="{{$order->delivery_cost}}" id="floatingInput" placeholder="name@example.com" />
                                                <label for="floatingInput">Coût de livraison</label>
                                            </div>
                                        </div>

                                    </div>
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection
