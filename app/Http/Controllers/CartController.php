<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
	public function update(Request $request)
	{
		$validate = Validator::make($request->all(), [
				'id' => 'required',
				'product_attribute_id' => 'nullable',
				'quantity' => 'required'
		]);
		if ($validate->fails()) {
			return back()->with('error', $validate->getMessageBag()->first());
		}
		$cart = Cart::getContext();
		$cart->putProduct((int)$request->get('id'), (int)$request->get('quantity'), (int)$request->get('product_attribute_id', 0));
		return back();
	}

	public function form_update_cart(Request $request)
	{
		$validate = Validator::make($request->all(), [
				'product_attribute' => 'required|array'
		]);
		if ($validate->fails()) {
			return back()->with('error', $validate->getMessageBag()->first());
		}
		foreach ($request->get('product_attribute') as $id => $product_attr) {
			DB::table('cart_has_product')
					->where('id', '=', $id)
					->update([
							'quantity' => (int)$product_attr['quantity']
					]);
		}
		return back()->with('success', "Mise à jour effectuer avec succès");
	}

	public function cart_page(Request $request)
	{
		$cart = Cart::getContext();
		$items = $cart->getItems();
		$total = collect($items)->reduce(function($i, $item) {
			return $i + ((int)$item['price'] * $item['quantity']);
		}, 0);
		return view('pages.cart', [
				'items' => $items,
				'total' => $total,
				'shipping' => 0
		]);
	}

	public function remove_item(Request $request, $id_item)
	{
		if ($id_item) {
			$cart = Cart::getContext();
			$cart->removeItem(intval($id_item));
			return back()->with('info', "Panier mis à jour avec succès");
		}
		return back()->with("error", "Article non définie");
	}
}
