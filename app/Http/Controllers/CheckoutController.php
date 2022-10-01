<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmOrder;
use App\Models\Cart;
use App\Models\CustomerBilling;
use App\Models\CustomerModel;
use App\Models\Options;
use App\Models\OrderDetails;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use function Sodium\randombytes_random16;

class CheckoutController extends Controller
{
	public function index()
	{
		$user = Auth::user();
		$customer_billings = collect([]);
		if ($user->group == "customer") {
			$customer = CustomerModel::query()->where("id_user", '=', Auth::id())->first();
			if ($customer) {
				$customer_billings = CustomerBilling::query()->where('id_customer', '=', $customer->id_customer)->get();
			}
		}
		$cart = Cart::getContext();
		$items = $cart->getItems();

		$total = collect($items)->reduce(function ($i, $item) {
			return $i + ((int)$item['price'] * $item['quantity']);
		}, 0);
		return view('pages.checkout', [
				'billings' => $customer_billings,
				'items' => $items,
				'total' => $total
		]);
	}

	public function confirmAdressCheckout(Request $request)
	{
		$address_id = $request->get('billing_address', 0);
		session()->put('billing_address', $address_id);
		return redirect()->to(route('payment.checkout'));
	}

	public function shipping()
	{

	}

	public function confirm_checkout(Request $request) {
		$validator = Validator::make($request->all(), [
				'paymentOption' => 'required'
		]);
		if ($validator->fails()) {
			return back()->with('error', $validator->getMessageBag()->first());
		}
		// Create order
		$cart = Cart::getContext();
		$customer = CustomerModel::getContext();
		if (!$customer || !$cart) {
			return back()->with('error', "Une erreur s'est produite pendant l'envoie de votre commande");
		}
		$items = $cart->getItems();
		if (session()->has('billing_address')) {
			$address_shipping_id = (int)session()->get('billing_address');
		} else {
			// Recuperer l'addres par default
			$address_billing = CustomerBilling::query()
					->where('id_customer', '=', $customer->id_customer)
					->first();
			if ($address_billing)  {
				$address_shipping_id = $address_billing->id_billing;
			}
		}

		$shipping_number = Options::query()->where('name', '=', 'SHIPPING_NUMBER')->first();
		$order  = Orders::create([
				'id_customer' => $customer->id_customer,
			'id_billing' => (int)$address_shipping_id,
			'id_cart' => $cart->id_cart,
			'reference' => Str::uuid()->toString(),
			'payment' => $request->get('paymentOption'),
			'total_paid' => $cart->getTotal(),
			'active' => 1,
			'shipping_number' => (int)$shipping_number->value,
			'total_products' => count($items),
			'delivery_cost' => 0
		]);

		// Add order details

		foreach ($items as $item) {
			$order_detail = OrderDetails::create([
					'id_order' => $order->id_order,
				'product_quantity' => $item['quantity'],
				'product_name' => $item['product_name'],
				'product_price' => $item['price'],
				'product_reference' => $item['reference'],
				'attribute_name' => $item['name']
			]);
		}

		$shipping_number->update([
				'value' => (string)(intval($shipping_number->value) + 1)
		]);

		// Envoyer un mail à l'administrateur
		$admin_notif = "tiafenofnel@gmail.com";
		try {
			Mail::to($admin_notif)->send(new ConfirmOrder($order));
		} catch (\Swift_TransportException $e) {
			Log::critical($e->getMessage());
		}

		// supprimer le panier
		$cart->update([
				'active' => 0
		]);
		if (session()->has('lg_cart')) {
			session()->remove('lg_cart');
		}
		return redirect()->to(route('confirm.order'));
	}

	public function confirm_order() {
		return view('pages.confirmation-order');
	}


	public function payment()
	{
		$cart = Cart::getContext();
		$items = $cart->getItems();

		$total = collect($items)->reduce(function ($i, $item) {
			return $i + ((int)$item['price'] * $item['quantity']);
		}, 0);
		return view("pages.checkout-payment", [
				'items' => $items,
				'total' => $total
		]);
	}
}