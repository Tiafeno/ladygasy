<?php

namespace App\Traits;

use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
      'reference' => 'nullable',
      'weight' => 'nullable',
      'price' => 'required',
      'categories' => 'nullable', // Array of ids
      'type' => 'required', // type simple or combination
      'description' => 'nullable',
      'description_short' => 'nullable',
      'active' => 'required'
    ]);
    if ($validator->fails()) {
      return response(['message' => $validator->getMessageBag()->first()], 400);
    }
    $name = $request->get('name');
    try {
      $product = ProductModel::create([
        'name' => $name,
        'slug_name' => Str::slug($name),
        'type' =>  $request->get('type', 'simple'),
        'ean13' => $request->get('ean13'),
        'quantity' => (int)$request->get('quantity'),
        'minimal_quantity' => (int)$request->get('minimal_quantity'),
        'reference' => (string)$request->get('reference'),
        'description' => $request->get('description'),
        'description_short' => $request->get('description_short'),
        'price' => floatval($request->get('price', 0)),
        'active' => $request->get('active', 0)
      ]);
      return response(['id' => $product->id_product]);
    } catch (\Exception $e) {
      return response(['message' => $e->getMessage()], 401);
    }
  }




}
