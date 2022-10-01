<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductModel extends Model
{
	use HasFactory;

	protected $table = "product";
	protected $primaryKey = "id_product";
	/**
	 * The model's default values for attributes.
	 *
	 * @var array
	 */
	protected $attributes = [
			'active' => false,
	];
	protected $fillable = [
			"name",
			"slug_name",
			"image",
			"type",
			"ean13",
			"quantity",
			"minimal_quantity",
			"reference",
			"width",
			"height",
			"weight",
			"active",
			"price",
			"description",
			"description_short"
	];
	/**
	 * The attributes that should be cast.
	 *
	 * @var array
	 */
	protected $casts = [
			'active' => 'boolean',
	];


	public function getCategories(): array
	{
		$category_join = DB::table('product_has_category')->where('id_product', $this->id_product)->get();
		return $category_join->map(function ($i) {
			return Category::query()->find($i->id_category);
		})->filter(fn($k) => ($k instanceof Model) && $k->active)->toArray();
	}

	public function addCategories(array $data)
	{
		$category_join = DB::table('product_has_category')
				->where('id_product', $this->id_product)
				->get();
		$ids = $category_join->map(fn($ctg) => $ctg->id_category)->toArray();
		foreach ($data as $new_ctg_id) {
			$new_ctg_id = intval($new_ctg_id);
			if (!in_array($new_ctg_id, $ids)) {
				DB::table('product_has_category')->insert([
						'id_product' => $this->id_product,
						'id_category' => $new_ctg_id
				]);
			}
		}
		return true;
	}

	public function getDefaultAttribute()
	{
		$attribute_join = DB::table('product_attribute');
		$attribute_join->where([
				'id_product' => $this->id_product
		]);
		$min_price = $attribute_join->min('price');
		$result = $attribute_join->where([
				'price' => intval($min_price)
		])->first();
		if ($result) {
			$combination = DB::table('combinations')
					->where('id_product_attribute', $result->id_product_attribute)
					->first();
			if ($combination) {
				$attribute = AttributeModel::query()
						->where('id_attribute', $combination->id_attribute)
						->first();
				if ($attribute) {
					return [
							'product_attribute_id' => $result->id_product_attribute,
							'attribute_id' => $attribute->id_attribute,
							'name' => $attribute->name,
							'price' => $result->price,
							'quantity' => $result->quantity
					];
				}
			}
		}
		return [
				'product_attribute_id' => 0,
				'attribute_id' => 0,
				'name' => '',
				'price' => $this->price,
				'quantity' => $this->quantity
		];
	}

	public function getPrice($id_product_attribute = 0) {
		if ($this->type == "simple") return $this->price;
		if ($id_product_attribute) {
			$attribute = DB::table('product_attribute')
					->where('id_product_attribute', intval($id_product_attribute))
					->first();
			if ($attribute) {
				return $attribute->price;
			}
		} else {
			$default = $this->getDefaultAttribute();
			return $default['price'];
		}
		return 0;
	}

	public function removeCategory($id_category)
	{
		$category_join = DB::table('product_has_category')
				->where([
						'id_product' => $this->id_product,
						'id_category' => intval($id_category)
				])
				->first();
		if ($category_join) $category_join->delete();
	}


	public function getImage($size = "large"): ?string
	{
		$image_name = $this->image;
    $disk = Storage::disk('local');
		if ($image_name && !$size == "original") {
			return $disk->url('product/thumbnail/'.$size.'-' . $image_name);
		} else {
      return $disk->url('product/'. $image_name);
    }
	}

}
