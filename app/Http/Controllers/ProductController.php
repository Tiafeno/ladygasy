<?php

namespace App\Http\Controllers;

use App\Models\ProductAttribute;
use App\Models\ProductModel;
use App\Traits\ProductManager;
use Illuminate\Http\Request;

class ProductController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $products = ProductModel::all();

  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   */
  public function show(Request $request, $id)
  {
    $id_attribute = (int)$request->get('attribute', 0);
    $quantity_default = 0;
    $attributes = [];
    $product = ProductModel::query()->find(intval($id));
    if ($product->type == "combination") {
      $attributes = ProductAttribute::query()->where('id_product', '=', (int)$product->id_product)->get();
      if ($id_attribute) {
        $attr = $attributes->first(fn($a) => $a->id_product_attribute == $id_attribute);
        if ($attr) {
          $quantity_default = $attr->quantity;
        }
      }

    }

		return view('pages.product-single', [
      'product' => $product,
      'attributes' => $attributes,
      'id_attribute' => $id_attribute,
      'price' => $product->getPrice(),
      'quantity' => $quantity_default
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
