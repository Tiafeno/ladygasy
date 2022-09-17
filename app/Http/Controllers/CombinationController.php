<?php

namespace App\Http\Controllers;

use App\Models\AttributeModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CombinationController extends Controller
{
	public function fetch(Request $request, $id_product) {
		$product_attributes = DB::table('product_attribute')
				->where('id_product', '=', intval($id_product))
				->get();
		$data = $product_attributes->map(function($pAttr) {
				return [
						'id' => (int)$pAttr['id_product_attribute'],
						'name' => $pAttr['name'] ?? '',
						'reference' => $pAttr['reference'] ?? '',
						'ean13' => $pAttr['ean13'] ?? '',
						'quantity' =>  (int)$pAttr['quantity'] ?? 0,
						'price' => $pAttr['price'] ?? 0,
					'default_on' => boolval($pAttr['default_on'] ?? 0)
				];
		});

		return response($data->toArray());
	}

	public function product_combination(Request $request, $id_product)
	{
		$validator = Validator::make($request->all(), [
				'reference' => "nullable",
				'ean13' => "nullable",
				'quantity' => "required|numeric",
				'price' => "required|numeric",
				'attributes' => "required|array" // array of attribute id
		]);
		if ($validator->fails()) {
			return response(['message' => $validator->getMessageBag()->first()], 401);
		}
		try {
			$product = ProductModel::query()->find(intval($id_product));
			if ($product) {
				// Crée une attribut de produit
				$name = '';
				if (is_array($request->get('attributes'))) {
					$attribute_ids = $request->get('attributes');
					foreach ($attribute_ids as $attr_id) {
						$attr = AttributeModel::query()->find(intval($attr_id), ['id_group', 'name']);
						if ($attr) {
							$group = Db::table('product_group')
									->where('id_product_group', '=', $attr->id_group)
									->first(['name']);
							$name .= $group->name." - ".$attr->name;
						}
					}
					$id_product_attribute = DB::table('product_attribute')->insertGetId([
							'id_product' => intval($id_product),
							'name' => $name,
							'reference' => $request->get('reference'),
							'ean13' => $request->get('ean13'),
							'quantity' => (int)$request->get('quantity', 0),
							'price' => (int)$request->get('price', 0),
					]);
					if ($id_product_attribute) {
						foreach ($attribute_ids as $attr_id) {
							$attr = AttributeModel::query()->find(intval($attr_id), ['id_group']);
							if ($attr) {
								DB::table('combinations')->insert([
										'id_product_attribute' => $id_product_attribute,
										'id_attribute' => intval($attr_id),
										'id_product_group' => $attr->id_group
								]);
							}
						}
					}
					return response(['message' => "Opération effectuer avec succès"]);
				} else {
					return response(['message' => "L'attributes ne pas de type tableau"], 401);
				}
			} else {
				return response(['message' => "Le produit est introuvable."], 401);
			}
		} catch (\Exception $e) {
			Log::error($e->getMessage());
			return response(['message' => $e->getMessage()], 401);
		}

	}

	public function update_combination(Request $request, $id_combination)
	{

	}

	public function delete_combination(Request $request, $id_combination)
	{

	}
}
