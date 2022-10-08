<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
	use HasFactory;

	protected $table = "orders";
	protected $primaryKey = "id_order";
	protected $fillable = [
			'id_customer',
			'id_billing',
			'id_cart',
			'reference',
			'payment',
			'total_paid',
			'active',
			'shipping_number',
			'total_products',
			'current_state',
			'delivery_cost'
	];

	protected $casts = [
			'total_paid' => 'integer',
	];

	public static function status()
	{
		return [
				[
						'code' => 1,
						'name' => "Nouveau"
				], [
						'code' => 2,
						'name' => "En attente de validation"
				], [
						'code' => 3,
						'name' => "Validée "
				], [
						'code' => 4,
						'name' => "En préparation"
				], [
						'code' => 5,
						'name' => "Expédiée"
				],
				[
						'code' => 6,
						'name' => "Payée"
				], [
						'code' => 7,
						'name' => "Livrée"
				],
				[
						'code' => 8,
						'name' => "Annulée"
				]

		];
	}

	public function getItems(): array
	{
		$order_details = OrderDetails::query()->where('id_order', '=', $this->id_order)->get();
		return $order_details->toArray();
	}

	public function getStatus(): string
	{
		$status_code = $this->status;
		$status = collect(static::status())->first(fn($s) => $s['code'] == $status_code);
		return $status['name'] ?? "";
	}

	public function getStatusCode(): int {
		$status = collect(static::status())->first(fn($s) => $s['code'] == $this->status);
		return $status['code'] ?? 1;
	}

	public function getTotal(): int
	{
		$items = $this->getItems();
		return collect($items)->sum(fn($item) => $item['product_price'] * $item['product_quantity']);
	}

	public function getShippingAddress(): array {
		$customer_billing = CustomerBilling::query()->find($this->id_billing);
		if ($customer_billing instanceof Model) {
				return $customer_billing->toArray();
		}
		return [];
	}

}
