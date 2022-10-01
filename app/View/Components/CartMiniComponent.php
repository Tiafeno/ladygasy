<?php

namespace App\View\Components;

use App\Models\Cart;
use Illuminate\View\Component;

class CartMiniComponent extends Component
{
	/**
	 * Create a new component instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Get the view / contents that represent the component.
	 *
	 * @return \Illuminate\Contracts\View\View|\Closure|string
	 */
	public function render()
	{
		$cart = Cart::getContext();
		$items = $cart->getItems();
		$total = collect($items)->reduce(function($i, $item) {
			return $i + ((int)$item['price'] * $item['quantity']);
		}, 0);
		return view('components.cart-mini-component', [
				'items' => $items,
			'total' => $total
		]);
	}
}
