<?php

namespace App\Traits;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

trait CategoryManager
{
  public function index_admin() {
    return view('admin.catalogue.categories');
  }

  public function all_admin(Request $request) {
    $categories = Category::query()->where('active', '=', 1)->get();
    return response($categories->toArray());
  }

  public function store_admin(Request $request) {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string',
      'parent' => 'nullable',
      'description' => 'nullable'
    ]);
    if ($validator->fails()) {
      return response(['success' => false, 'message' => $validator->getMessageBag()->first()], 400);
    }
    $name_slug = Str::slug($request->name);
    $parent = 0;
    if ($request->parent) {
      // si parent exist
      $category_parent = Category::query()->find(intval($request->parent));
      if (!$category_parent) return response(['message' => "Categorie parent introuvable"], 400);
      $parent = intval($request->parent);
    }
    try {
      // TODO: Vérifier si la catégories existe déja et désactiver
      $findCat = Category::query()
        ->where([
          'name' => $request->name,
          'active' => 0
        ])
        ->first();
      if ($findCat) {
        $category = $findCat;
        $category->active = 1;
        $category->id_parent = $parent;
        $category->description = $request->description ?? '';
        $category->save();
      } else {
        $category = Category::create([
          'name' => $request->name,
          'slug_name' => $name_slug,
          'active' => true,
          'id_parent' => $parent,
          'description' => $request->description ?? ''
        ]);
      }

      return response(['message' => "Ajouter avec succès", 'id' => $category->id_category]);
    } catch (QueryException $e) {
      Log::debug($e->getMessage());
      return response(['message' => "Une catégorie de même nom existe déja"], 400);
    }
  }

  public function destroy_admin(Request $request, $id) {
    $category = Category::query()->find(intval($id));
    if ($category) {
      $category->active = 0;
      $category->save();
    }
    // Enlever la categorie pour les produits
    $relation = DB::table('product_has_category')->where('id_category', '=', intval($id))->get();
    $relation->map(function(Model $r) {
      $r->delete();
    });
    return response(['success' => true]);
  }
}
