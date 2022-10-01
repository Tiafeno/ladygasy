<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
		protected $table = "order_detail";
		protected $primaryKey = "id_order_detail";
		protected $fillable = [
				'id_order',
			'product_quantity',
			'product_name',
			'product_price',
			'product_reference',
			'attribute_name',
		];

		protected $casts = [
				'id_order' => 'integer',
				'product_price' => 'integer',
				'product_quantity' => 'integer'
		];
}
