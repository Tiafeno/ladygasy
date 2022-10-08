@extends('layouts.app')
@section('title', $category->name)
@section('content')
    <div class="container mt-lg-5 mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-none">
                    <div class="card-body">
                        <div>
                            <h3 class="mt-0 text-center product-single-title">{{ $category->name }} </h3>
                        </div>
                        <div class="row">
                            @if(!empty($articles))
                                @foreach($articles as $article)
                                <div class="col-md-4 col-xs-12">
                                    <x-product-item :product-id="$article->id_product"></x-product-item>
                                </div>
                                @endforeach
                            @endif
                            @if(empty($article))
                                <div class="col-md-4 col-xs-12">
                                    Aucun
                                </div>
                            @endif
                        </div> <!-- end row-->

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
    </div>
@endsection
