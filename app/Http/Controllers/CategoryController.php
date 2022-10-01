<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductModel;
use App\Traits\CategoryManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    use CategoryManager;

		public function index($category_slug) {
			$category = Category::query()->where('slug_name', '=', $category_slug)->first();
			if ($category) {
				$products = DB::table('product_has_category')->where([
						'id_category' => $category->id_category
				])->get();
				return view('pages.archive-category', [
						'category' => $category,
					'articles' => $products
				]);
			} else {
				return abort(404);
			}
		}
}
