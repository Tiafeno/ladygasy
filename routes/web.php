<?php

use App\Http\Controllers\AdminAttributeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CombinationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ZoneController;
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
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');

Route::get('/products/{id}-{slug}.html', [ProductController::class, 'show'])->name('show.product');
Route::get('/categories/{slug}', [CategoryController::class, 'index'])->name('index.category');
Route::post('cart', [CartController::class, 'update'])->name('update.cart');
Route::post('form-cart', [CartController::class, 'form_update_cart'])->name('form.update.cart');
Route::get('cart', [CartController::class, 'cart_page'])->name('page.cart');
Route::get('cart/item/{id_item}/remove', [CartController::class, 'remove_item'])->name('cart.remove.item');
Route::get('order/{idc}/confirm', [CheckoutController::class, 'confirm_order'])->name('confirm.order');

Route::group([ 'middleware' => ['auth']], function () {
	Route::post('customer/address-shipping', [CustomerController::class, 'shippingAddress'])->name('create.shipping.customer');
	Route::post('checkout/confirm-shipping-address', [CheckoutController::class, 'confirmAdressCheckout'])->name('confirm.address.checkout');
	Route::get('checkout', [CheckoutController::class, 'index'])->name('index.checkout');
	Route::get('checkout/shipping-information', [CheckoutController::class, 'shipping'])->name('shipping.checkout');
	Route::get('checkout/payment', [CheckoutController::class, 'payment'])->name('payment.checkout');
	Route::post('checkout/order', [CheckoutController::class, 'confirm_checkout'])->name('confirm.checkout');
});

Route::redirect('ld-admin/', 'ld-admin/dashboard');
Route::group(['prefix' => 'ld-admin', 'middleware' => ['auth', 'is.admin']], function () {
  Route::get('orders', [AdminController::class, 'index_order_admin'])->name('index.admin.orders');
  Route::get('orders/{id_order}', [AdminController::class, 'show_order_admin'])->name('show.admin.order');
  Route::patch('orders/{id_order}', [AdminController::class, 'update_order'])->name('update.admin.order');
  Route::get('cards', [AdminController::class, 'index_cards_admin'])->name('index.admin.cards');
  Route::get('products', [AdminController::class, 'index_product_admin'])->name('index.admin.product');
  Route::post('products', [AdminController::class, 'store_product_admin'])->name('store.admin.product');
  Route::get('product/{id_product}', [AdminController::class, 'fetch'])->name('product');
  Route::put('product/{id_product}', [AdminController::class, 'update_product'])->name('update.product');
  Route::post('product/{id_product}/image', [AdminController::class, 'update_image_product'])->name('update.image.product');
  Route::delete('product/{id_product}/image', [AdminController::class, 'remove_image_product'])->name('remove.image.product');
  Route::post('product/{id_product}/combination', [CombinationController::class, 'product_combination'])->name('post.product.combination');
	Route::get('product/{id_product}/combinations', [CombinationController::class, 'fetch'])->name('product.combination');
	Route::put('combination/{id_combination}', [CombinationController::class, 'update_combination'])->name('update.combination');
	Route::delete('combination/{id_combination}', [CombinationController::class, 'delete_combination'])->name('delete.combination');

	Route::get('zone', [ZoneController::class, 'index'])->name('index.admin.zone');
	Route::post('zone', [ZoneController::class, 'create'])->name('create.admin.zone');

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
Route::get('i/p/{size}/{image}', [ImageController::class, 'image'])->name('image');
Auth::routes();


