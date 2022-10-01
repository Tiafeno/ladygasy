<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CustomerModel;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

class LoginController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers {
		AuthenticatesUsers::login as AuthLogin;
	}


	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = RouteServiceProvider::HOME;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

	/**
	 * Validate the user login request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return void
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	protected function validateLogin(Request $request)
	{
		$request->validate([
				$this->username() => 'required|string|phone_valid',
				'password' => 'required|string',
		], [
				'phone.phone_valid' => "Numéro de téléphone invalide"
		]);
	}

	/**
	 * Handle a login request to the application.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function login(Request $request)
	{
		$is_valid = true;
		$phone = $request->input($this->username(), 0);
		try {
			$phoneUtil = PhoneNumberUtil::getInstance();
			$swissNumber = $phoneUtil->parse($phone, "MG");
			if ($phoneUtil->isValidNumber($swissNumber)) {
				$phone = $swissNumber->getNationalNumber();
			} else {
				$is_valid = false;
			}
		} catch (NumberParseException $e) {
			$is_valid = false;
		}
		$inputs = collect($request->all())->map(function ($value, $key) use ($phone, $is_valid) {
			if ($key == $this->username() && $is_valid) {
				$value = "0{$phone}";
			}
			return $value;
		})->toArray();
		$request->replace($inputs);
		$redirect_to = $request->input('redirect_to', null);
		if ($redirect_to) $this->redirectTo = $redirect_to;
		return $this->AuthLogin($request);
	}

	/**
	 * The user has logged out of the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return mixed
	 */
	protected function loggedOut(Request $request)
	{
		session()->remove('lg_cart');
	}

	/**
	 * Get the login username to be used by the controller.
	 *
	 * @return string
	 */
	public function username()
	{
		return 'phone';
	}

	/**
	 * The user has been authenticated.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param mixed $user
	 * @return mixed
	 */
	protected function authenticated(Request $request, $user)
	{
		$customer = CustomerModel::query()->where('id_user', '=', $user->id_user)->first();
		if ($customer) {
			$customer_cart = Cart::query()->where([
					'id_customer' => $customer->id_customer,
					'active' => 1
			])->first();
			if ($customer_cart) {
				if (session()->has('lg_cart')) {
					// seule les panier vide sont désactiver
					$join = DB::table('cart_product')
							->where('id_cart', '=', $customer_cart->id_cart)
							->first();
					if ($join) {
						$has_products = DB::table('cart_has_product')
								->where('id_cart_product', '=', $join->id_cart_product)
								->get();
						if ($has_products->count() == 0) {
							$customer_cart->update([
									'active' => 0
							]);
						}
					}
				} else {
					session()->put('lg_cart', $customer_cart->secure_key);
				}
			}
		}

	}
}
