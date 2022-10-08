@extends('layouts.admin')
@section('title', "Tous les commandes")
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Payment Status</th>
                                    <th>Total</th>
                                    <th>Payment Method</th>
                                    <th style="width: 125px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>#{{$order->id_order}} </td>
                                    <td>
                                        {{(new DateTime($order->created_at))->format('d l Y H:m')}}
                                    </td>
                                    <td>
                                        <h5><span class="badge badge-outline-dark"><i class="mdi mdi-bitcoin"></i> {{$order->getStatus()}}</span></h5>
                                    </td>
                                    <td>
                                        {{$order->getTotal()}} MGA
                                    </td>
                                    <td class="upper-text">
                                        {{$order->payment}}
                                    </td>
                                    <td>
                                        <a href="{{route('confirm.order', ['idc' => \Illuminate\Support\Facades\Crypt::encryptString((string)$order->id_order)])}}" target="_blank" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                        <a href="{{route('show.admin.order', ['id_order' => $order->id_order])}}" class="action-icon">
                                            <i class="mdi mdi-square-edit-outline"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection
