@extends('layouts.admin')
@section('title', "Tous les produits")
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="javascript: void(0);">Tableau de bord</a></li>
@endsection
@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body" id="app-admin-product">
          <!-- vue app -->
        </div>
      </div> <!-- end card-->
    </div> <!-- end col -->
  </div>
  <!-- end row -->
@endsection
