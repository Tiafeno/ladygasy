@extends('layouts.admin')
@section('title', "Tous les categories")
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="javascript: void(0);">Tableau de bord</a></li>
@endsection
@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div id="app-category">
            <category-component></category-component>
          </div>

        </div> <!-- end card-body-->
      </div> <!-- end card-->
    </div> <!-- end col -->
  </div>
  <!-- end row -->
@endsection
