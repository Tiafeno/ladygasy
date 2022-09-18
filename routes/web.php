<?php

use App\Http\Controllers\AdminAttributeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CombinationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::redirect('ld-admin/', 'ld-admin/dashboard');
Route::group(['prefix' => 'ld-admin', 'middleware' => ['auth', 'is.admin']], function () {
  Route::get('products', [AdminController::class, 'index_product_admin'])->name('index.admin.product');
  Route::post('products', [AdminController::class, 'store_product_admin'])->name('store.admin.product');

  // Combination
  Route::get('product/{id_product}/combinations', [CombinationController::class, 'fetch'])->name('product.combination');
  Route::get('product/{id_product}', [AdminController::class, 'fetch'])->name('product');
  Route::put('product/{id_product}', [AdminController::class, 'update_product'])->name('update.product');
  Route::post('product/{id_product}/image', [AdminController::class, 'update_image_product'])->name('update.image.product');
  Route::put('combination/{id_combination}', [CombinationController::class, 'update_combination'])->name('update.combination');
  Route::delete('combination/{id_combination}', [CombinationController::class, 'delete_combination'])->name('delete.combination');
  Route::post('product/{id_product}/combination', [CombinationController::class, 'product_combination'])->name('post.product.combination');

  Route::options('products', [AdminController::class, 'products_admin'])->name('admin.products');
  Route::get('product/created', [AdminController::class, 'create_product_admin'])->name('created.admin.product');

  Route::get('categories', [CategoryController::class, 'index_admin'])->name('index.admin.categories');
  Route::delete('categories/{id}', [CategoryController::class, 'destroy_admin'])->name('destroy.admin.categories');
  Route::options('categories', [CategoryController::class, 'all_admin'])->name('retrieve.admin.categories');
  Route::post('categories', [CategoryController::class, 'store_admin'])->name('store.admin.categories');

  Route::group(['prefix' => 'attributes'], function() {
    Route::get('/', [AdminAttributeController::class, 'index'])->name('index.product.attribute');
    Route::options('/', [AdminAttributeController::class, 'attributes'])->name('options.product.attribute');
    Route::post('/groups', [AdminAttributeController::class, 'store_group'])->name('store.product.group');
    Route::get('/groups', [AdminAttributeController::class, 'group'])->name('index.product.group');
    Route::post('/', [AdminAttributeController::class, 'store_attribute'])->name('store.attribute');
    Route::delete('/{id}', [AdminAttributeController::class, 'destroy_attribute'])->name('destroy.attribute');
  });

  Route::group(['prefix' => 'group'],function() {
    Route::options('/{id_group}/attributes', [AdminAttributeController::class, 'group_attributes'])->name('options.group.attribute');
  });

  Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
  Route::resource('customers', CustomerController::class);
});

Route::group(['prefix' => 'esp-client', 'middleware' => ['auth']], function() {
  Route::redirect('/', 'esp-client/me');
});

Auth::routes();


