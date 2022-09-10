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


  public function getCategories(): array {
    $category_join = DB::table('product_has_category')->where('id_product', $this->id)->get();
    return $category_join->map(function ($i) {
      try {
        return Category::query()->findOrFail($i->id_category);
      } catch (ModelNotFoundException $e) {
        return null;
      }
    })->filter(fn(Category $k) => $k && $k->active)->toArray();
  }

}
