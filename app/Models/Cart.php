<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Cart extends Model
{
	use HasFactory;

	protected $primaryKey = "id_cart";
	protected $table = "cart";
	protected $fillable = [
			'id_cart',
			'secure_key',
			'id_guest',
			'id_customer',
			'active'
	];

	protected $casts = [
			'id_guest' => 'integer',
			'id_customer' => 'integer'
	];

	public static function getContext(): ?Cart
	{
		$key_secure = Str::uuid()->toString();
		if (Auth::check()) {
			$user = Auth::user();
			$user_id = $user->getAuthIdentifier();
			$customer = CustomerModel::query()->where('id_user', $user_id)->first();
			if ($customer) {
				// is customer
				$cart = static::query()->where([
						'id_customer' => $customer->id_customer,
						'active' => 1
				])->first();
				if (!$cart) {
					// Si une panier existe déja ?
					if (!session()->has('lg_cart')) {
//						$guest_cart_secure_key = session()->get('lg_cart', null);
//						$guest_cart = static::query()->where('secure_key', '=', $guest_cart_secure_key)->first();
						$cart = static::create([
								'secure_key' => $key_secure,
								'id_guest' => 0,
								'id_customer' => $customer->id_customer
						]);
						DB::table('cart_product')->insert([
								'id_cart' => $cart->id_cart
						]);
					} else {
						$key = session()->get('lg_cart');
						$cart_ = static::query()->where('secure_key', '=', $key)->first();
						if ($cart_) {
							$cart_->update([
									'id_customer' => $customer->id_customer
							]);
							$cart = $cart_;
						}
					}
				}
				if (!session()->has('lg_cart'))
					session()->put('lg_cart', $cart->secure_key);
				return $cart;
			}
		}

		if (session()->has('lg_cart')) {
			$guest_cart_secure_key = session()->get('lg_cart', null);
			$guest_cart = static::query()->where('secure_key', '=', $guest_cart_secure_key)->first();
			if ($guest_cart) return $guest_cart;
		}
		$guest = GuestModel::getContext();
		// si le client posséde déja une panier
		$cart = static::query()->where('id_guest', '=', $guest->id_guest)->first();
		if ($cart) {
			session()->put('lg_cart', $cart->secure_key);
			return $cart;
		}
		session()->put('lg_cart', $key_secure);
		$cart = static::create([
				'secure_key' => $key_secure,
				'id_guest' => $guest->id_guest,
				'id_customer' => 0
		]);
		DB::table('cart_product')->insert([
				'id_cart' => $cart->id_cart
		]);
		return $cart;
	}

	public function getItems()
	{

		$product_cart = DB::table('cart_product')->where('id_cart', $this->id_cart)->first();
		if ($product_cart) {
			$join = DB::table('cart_has_product')->where('id_cart_product', '=', $product_cart->id_cart_product)->get();
			return $join->map(function ($item) {
				$product = ProductModel::query()->where('id_product', '=', $item->id_product)->first();
				if ($item->id_product_attribute) {
					$product_attribute = ProductAttribute::query()
							->where('id_product_attribute', '=', $item->id_product_attribute)
							->first();
					return [
							'id' => $item->id,
							'id_product' => $product_attribute->id_product,
							'id_attribute' => $product_attribute->id_product_attribute,
							"image" => $product->image,
							"product_name" => $product->name,
							'name' => $product_attribute->name,
							'price' => $product_attribute->price,
							'reference' => $product_attribute->reference,
							'quantity' => $item->quantity
					];
				}
				return [
						'id' => $item->id,
						'id_product' => $product->id_product,
						'id_attribute' => 0,
						'image' => $product->image,
						"product_name" => $product->name,
						'name' => $product->name,
						'price' => $product->price,
						'reference' => $product->reference,
						'quantity' => $item->quantity
				];
			})->toArray();
		}
		return [];
	}

	public function getTotal() {
		$total = collect($this->getItems())->reduce(function($i, $item) {
			return $i + ((int)$item['price'] * $item['quantity']);
		}, 0);
		return $total;
	}

	public function putProduct(int $id_product, int $quantity, int $id_product_attribute = 0): bool
	{
		$product = ProductModel::query()->where('id_product', $id_product)->first();
		if ($product) {
			$pAttribute = DB::table('product_attribute')->where('id_product_attribute', $id_product_attribute)->first();
			if ($pAttribute) {
				$attrQuantity = $pAttribute->quantity;
				if ($attrQuantity < $quantity) {
					session()->flash('error', "Quantité indisponible");
					return false;
				}
			} else {
				if ($product->quantity < $quantity) {
					session()->flash('error', "Quantité indisponible");
					return false;
				}
			}

			// Vérifier que le produit est déja dans le panier
			$his_product_cart = DB::table('cart_product')->where('id_cart', $this->id_cart)->first();
			if ($his_product_cart) {
				$cart_product_join = DB::table('cart_has_product')
						->where('id_cart_product', $his_product_cart->id_cart_product)
						->get();
				// Tous les produits
				$exist = false;
				foreach ($cart_product_join->toArray() as $element) {
					if ($id_product == $element->id_product && $id_product_attribute == $element->id_product_attribute) {
						DB::table('cart_has_product')
								->where('id_cart_product', '=', $element->id_cart_product)
								->update(['quantity' => $quantity + $element->quantity]);
						$exist = true;
					}
				}

				if (!$exist) {
					DB::table('cart_has_product')->insert([
							'id_cart_product' => $his_product_cart->id_cart_product,
							'id_product' => $id_product,
							'id_product_attribute' => $id_product_attribute,
							'quantity' => $quantity,
							'date_add' => Carbon::now()
					]);
				}
				return true;
			} else {
				$id_cart_product = DB::table('cart_product')->insertGetId([
						'id_cart' => $this->id_cart
				]);
				DB::table('cart_has_product')
						->where('id_cart_product', '=', $id_cart_product)
						->insert([
								'id_cart_product' => $id_cart_product,
								'id_product' => $id_product,
								'id_product_attribute' => $id_product_attribute,
								'quantity' => $quantity,
								'date_add' => Carbon::now()
						]);
				return true;
			}
		}
		return false;
	}

	public function removeItem(int $id_item)
	{
		DB::table("cart_has_product")
				->where('id', '=', $id_item)
				->delete();
		return true;
	}
}
