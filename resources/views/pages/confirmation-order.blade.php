@extends('layouts.app')
@section('title', 'Confirmation de commande')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row mt-4">
                    <div class="card mt-5 ">
                        <!-- Logo -->
                        <div class="card-body p-4">
                            <div>
                                <h3 class="mt-0 text-center product-single-title">COMMANDE #{{$id}}</h3>
                            </div>
                            <div class="text-left ">
                                <p class="font-17 mb-4">La commande no {{$id}} a été passée {{$date}} à 20 h 52 est actuellement <b>'{{$status}}'</b>.</p>
                            </div>
                            <h5>Order Details</h5>
                            <table class="table table-centered mb-0">
                                <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td>{{$item['name']}} (x{{$item['quantity']}})</td>
                                    <td>{{$item['total']}} MGA</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                                <tr class="font-18">
                                    <td class="fw-bold">Sous-Total: </td>
                                    <td>{{$total}} MGA</td>
                                </tr>
                                <tr class="font-18">
                                    <td class="fw-bold">Moyen de paiement: </td>
                                    <td>{{$payment}}</td>
                                </tr>
                                <tr class="font-18">
                                    <td class="fw-bold">Total: </td>
                                    <td >{{$total}} MGA</td>
                                </tr>
                                </tbody>
                            </table>

                            <div class="row mt-4">
                                <div class="col-sm-6">
                                    <a href="{{route('home')}}"
                                       class="btn text-muted btn-link d-inline-flex">
                                        <i class="material-symbols-outlined">keyboard_backspace</i> <span class="ms-1">Retour à la boutique</span> </a>
                                </div> <!-- end col -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection