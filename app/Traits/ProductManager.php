<?php

namespace App\Traits;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

trait ProductManager
{
  public function index_admin(Request $request){
    $products = [];
    return view('admin.catalogue.products', []);
  }

  public function create_admin() {
    return view('admin.catalogue.product-form');
  }

  public function store_admin(Request $request) {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'type' => 'required',
      'ean13' => 'nullable',
      'quantity' => 'required',
      'reference' => 'required',
      'weight' => 'nullable',
      'price' => 'required',
      'description' => 'nullable',
      'description_short' => 'nullable'
    ]);


  }
}
