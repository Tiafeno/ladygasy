@extends('layouts.admin')
@section('title', "Tous les clients")
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Numéro de téléphone</th>
                                    <th>Adresse email</th>
                                    <th>Date d'inscription</th>
                                    <th style="width: 125px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($customers as $customer)
                                <tr>
                                    <td>
                                        {{$customer->first_name}} {{$customer->last_name}}
                                    </td>
                                    <td>
                                      @if($customer->getUser())
                                        <h5><span class="badge badge-outline-dark"> {{$customer->getUser()->phone}}</span></h5>
                                      @endif
                                    </td>
                                    <td>
                                      @if($customer->getUser() && $customer->getUser()->email)
                                        {{$customer->getUser()->email}} MGA
                                      @else
                                        Pas d'adresse email
                                      @endif
                                    </td>
                                    <td class="upper-text">
                                        {{(new DateTime($customer->created_at))->format('d l Y H:m')}}
                                    </td>
                                    <td>
                                        <a href="" target="_blank" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                        <a href="" class="action-icon">
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
