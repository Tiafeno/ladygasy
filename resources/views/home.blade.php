@extends('layouts.app')
@section('slider')
    <div id="header__slider">
        <div class="slide_title text-center" style="padding-top: 25vh">
            <h1 class=" header">ANTICELLULITE COMPLEX</h1>
            <h4>Try our perfect anti-cellulite complex with a hot body wrap for soft and healthy skin !</h4>
        </div>
    </div>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
            </div>
        </div>
    </div>
</div>
@endsection
