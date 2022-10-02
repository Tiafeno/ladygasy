<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\ProductModel;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class ProductSlider extends Component
{
    public $data = [];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($categories = [])
    {
        // Recuperer les 6 premiers categories qui posséde plus de produit
        $categories_query = Category::query()
          ->where('active', 1)
          ->whereIn('id_category', $categories)
          ->get();
        $this->data = $categories_query->map(function($cat) {
          $product_cat = DB::table('product_has_category')
            ->where('id_category', '=', $cat->id_category)
            ->take(50)
            ->get(['id_product']);
          $products = $product_cat->map(function($join) {
            return $join->id_product;
          });
          return [
            'id' =>  $cat->id_category,
            'name' => $cat->name,
            'slug' => $cat->slug_name,
            'desc' => $cat->description,
            'url' => route('index.category', ['slug' =>  $cat->slug_name]),
            'products' => $products // array of product id
          ];
        });
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.product-slider', ['data' => $this->data]);
    }


    protected function countCategoryProduct($id_category) {
      $product_categories_count = DB::table('product_has_category')
        ->where('id_category', '=', intval($id_category))
        ->count();
        return $product_categories_count;
    }
}
