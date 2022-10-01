<?php

namespace App\Services;

use App\Models\ProductModel;

class ProductHandler
{
	public static function getProductUrl(int $id_product, $id_product_attribute = 0) {
		$product = ProductModel::query()->where('id_product', '=', $id_product)->first();
		$slug_name = $product->slug_name;
		return route('show.product', ['id' => $id_product, 'attribute' => $id_product_attribute, 'slug' => $slug_name]);
	}
}
