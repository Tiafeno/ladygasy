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
}
