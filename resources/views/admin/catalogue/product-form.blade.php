@extends('layouts.admin')
@section('title', "")
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="javascript: void(0);">Tableau de bord</a></li>
  <li class="breadcrumb-item"><a href="{{route('index.admin.product')}}">Tous les produits</a></li>
@endsection
@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">


        </div> <!-- end card-body-->
      </div> <!-- end card-->
    </div> <!-- end col -->
  </div>
  <!-- end row -->
@endsection
