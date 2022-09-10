@extends('layouts.admin')
@section('title', "Tous les attributes et caratéristiques")
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="javascript: void(0);">Tableau de bord</a></li>
@endsection
@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div id="app-attribute">
            <attribute-component></attribute-component>
          </div>

        </div> <!-- end card-body-->
      </div> <!-- end card-->
    </div> <!-- end col -->
  </div>
  <!-- end row -->
@endsection
