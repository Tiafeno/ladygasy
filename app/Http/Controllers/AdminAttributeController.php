<?php

namespace App\Http\Controllers;

use App\Models\AttributeModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminAttributeController extends Controller
{
  public function __constructor()
  {
    $this->middleware(['is.admin']);
  }

  public function index()
  {
    return view('admin.catalogue.attributes', []);
  }

  public function group()
  {
    $groups = DB::table('product_group')->get();
    return response($groups->toArray());
  }

  public function attributes(Request $request)
  {
    $attrs = AttributeModel::all();

    return response($attrs->toArray());
  }

  public function store_group(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'type' => 'required|string', // select, radio, image
      'name' => 'required|string',
      'is_color' => 'nullable|boolean'
    ]);
    if ($validator->fails()) {
      return response(['message' => $validator->getMessageBag()->first()], 401);
    }

    try {
      $insert = DB::table('product_group')->insert([
        'type' => $request->type,
        'name' => $request->name,
        'slug_name' => Str::slug($request->name),
        'is_color' => $request->is_color && boolval($request->is_color)
      ]);
      return response(['success' => true]);
    } catch (\PDOException $e) {
      return response(['message' => $e->getMessage()], 400);
    }

    if ($insert) return response(['message' => "Ajouter avec succès"]);
    return response(['message' => "Une erreur s'est produit"], 400);
  }

  public function store_attribute(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'id_group' => 'required|numeric',
      'name' => 'required|string'
    ]);
    if ($validator->fails()) {
      return response(['message' => $validator->getMessageBag()->first()], 401);
    }
    // Vérifier que le group exist
    $query_group = DB::table('product_group')
      ->where('id_product_group', '=', (int)$request->id_group)
      ->first();
    if (!$query_group) {
      return response(['message' => 'Group introuvable'], 401);
    }

    $attribute = AttributeModel::create([
      'id_group' => $request->id_group,
      'name' => trim($request->name)
    ]);
    return response(['message' => "Attribut ajouter avec succès"], 200);
  }

  public function destroy_attribute(Request $request, $id)
  {
    $attr = AttributeModel::query()->find(intval($id));
    if ($attr) {
      $attr->delete();
      // Enlever la categorie pour les produits
      $product_attribute = DB::table('product_attribute');
      $relation = $product_attribute
        ->where('id_attribute', '=', intval($id))
        ->get();
      $relation->map(function (array $r) use ($product_attribute) {
        $product_attribute
          ->where('id_product_attribute', '=', (int)$r['id_product_attribute'])
          ->update(['id_attribute', 0]);
      });
    }

    return response(['success' => true]);
  }
}
