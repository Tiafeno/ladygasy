<?php

namespace App\Traits;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait OrderManager
{
	private int $limit = 10;

	public function index_order_admin(Request $request)
	{
		$page = $request->get('page', 1);
		$orders = Orders::query()
				->get();
		return view('admin.orders', [
				'orders' => $orders
		]);
	}

	public function show_order_admin(Request $request, $id_order)
	{
		$order = Orders::find(intval($id_order));
		if ($order) {
			$shipping_address = $order->getShippingAddress();
			return view('admin.order-show', [
					'order' => $order,
					'address' => $shipping_address,
					'status_code' => $order->getStatusCode()
			]);
		}
		return redirect()->to(route('index.admin.orders'));
	}

	public function update_order(Request $request, $id_order) {
		Validator::make($request->all(), [
				'status' => 'required',
				'cost' => 'required'
		])->validate();
		$order = Orders::query()->find(intval($id_order));
		if ($order) {
			$order->status = (int)$request->get('status', 1);
			$order->delivery_cost = (int)$request->get('cost', 0);
			$order->save();
			return back()->with('info', "Commande mis à jour avec succès");
		}
		return redirect()->to(route('index.admin.orders'));
	}
}