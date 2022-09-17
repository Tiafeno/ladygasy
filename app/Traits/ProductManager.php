<?php

namespace App\Traits;

use App\Models\ProductModel;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

trait ProductManager
{
  public function index_product_admin(Request $request){
    return view('admin.catalogue.products');
  }

  public function create_product_admin() {
    return view('admin.catalogue.product-form');
  }

  public function products_admin(Request $request){
    $products = ProductModel::query()->get();
    return response($products->toArray());
  }

  public function store_product_admin(Request $request) {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'ean13' => 'nullable',
      'quantity' => 'required',
      'reference' => 'required',
      'weight' => 'nullable',
      'price' => 'required',
      'categories' => 'nullable',
      'type' => 'required', // type simple or combination
      'combinations' => 'nullable',
      'description' => 'nullable',
      'description_short' => 'nullable'
    ]);


  }
}
