@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-4">
                    <x-product-item product-id="1"></x-product-item>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
