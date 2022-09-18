<?php

namespace App\Traits;

use App\Http\Requests\ProductRequest;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

trait ProductManager
{
	public function index_product_admin(Request $request)
	{
		return view('admin.catalogue.products');
	}

	public function create_product_admin()
	{
		return view('admin.catalogue.product-form');
	}

	public function fetch(Request $request, $id_product)
	{
		$product = ProductModel::query()->find(intval($id_product));
		if ($product) {
			$product->categories = $product->getCategories();
			return response($product);
		}
		return response(new \stdClass());
	}

	public function products_admin(Request $request)
	{
		$products = ProductModel::query()->get();
		// Récuperer les categories de l'article
		$response = $products->map(function ($product) {
			$product->price = floatval($product->price);
			$product->categories = $product->getCategories();
			return $product;
		});
		return response($response->toArray());
	}

	public function store_product_admin(ProductRequest $request)
	{
		$name = $request->get('name');
		try {
			$product = ProductModel::create([
					'name' => $name,
					'slug_name' => Str::slug($name),
					'type' => $request->get('type', 'simple'),
					'ean13' => $request->get('ean13'),
					'quantity' => (int)$request->get('quantity'),
					'minimal_quantity' => (int)$request->get('minimal_quantity'),
					'reference' => (string)$request->get('reference'),
					'description' => $request->get('description'),
					'description_short' => $request->get('description_short'),
					'price' => floatval($request->get('price', 0)),
					'active' => $request->get('active', 0)
			]);

			// Ajoteur les catégories
			$categories = $request->get('categories', []);
			if (is_array($categories) && !empty($categories)) {
					$product->addCategories($categories);
			}
			return response(['id' => $product->id_product]);
		} catch (\Exception $e) {
			return response(['message' => $e->getMessage()], 401);
		}
	}

	public function update_product(ProductRequest $request, $id_product)
	{
		$product = ProductModel::query()->find(intval($id_product));
		if ($product) {
			$name = $request->get('name');
			$product->update([
					'name' => $name,
					'slug_name' => Str::slug($name),
					'type' => $request->get('type', 'simple'),
					'ean13' => $request->get('ean13'),
					'quantity' => (int)$request->get('quantity'),
					'minimal_quantity' => (int)$request->get('minimal_quantity'),
					'reference' => (string)$request->get('reference'),
					'description' => $request->get('description'),
					'description_short' => $request->get('description_short'),
					'price' => floatval($request->get('price', 0)),
					'active' => $request->get('active', 0)
			]);
			$categories = $request->get('categories', []);
			if (is_array($categories) && !empty($categories)) {
					$product->addCategories($categories);
			}
			return response(["message" => "Enregistrer avec succès"], 200);
		}
	}

	public function update_image_product(Request $request, $id_product) {
		$validator = Validator::make($request->all(), [
				"file" => ['required']
		]);
		if ($validator->fails()) {
			return response(['message' => $validator->getMessageBag()->first()], 401);
		}
		$uploadedFile = $request->file('file');
		$folder = "public/product";
		//$filename = time().$uploadedFile->getClientOriginalName();
		$disk = Storage::disk("local");
		$path = $disk->put($folder, $uploadedFile);
		if ($path) {
			$image_name = basename($path);
			$product = ProductModel::query()->find(intval($id_product));
			if ($product) {
				$product->update([
						'image' => $image_name
				]);
			}
			return response(["message" => "Fichier envoyer avec succèss"]);
		} else {
			return response([ "message" => "Une erreur s'est produite pendant l'envoie du fichier"], 401);
		}
	}
}
