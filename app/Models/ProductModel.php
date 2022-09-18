<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

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

	public function removeCategory($id_category) {
		$category_join = DB::table('product_has_category')
				->where([
						'id_product' => $this->id_product,
						'id_category' => intval($id_category)
				])
				->first();
		if ($category_join) $category_join->delete();
	}

}
