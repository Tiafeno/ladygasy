<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CustomerModel;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

class RegisterController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Register Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users as well as their
  | validation and creation. By default this controller uses a trait to
  | provide this functionality without requiring any additional code.
  |
  */

  use RegistersUsers;

  /**
   * Where to redirect users after registration.
   *
   * @var string
   */
  protected $redirectTo = '/login';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest');
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param array $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'firstname' => ['required', 'string', 'max:250'],
      'lastname' => ['required', 'string', 'max:250'],
      'phone' => ['required', 'string', 'phone_valid'],
      'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:6', 'confirmed'],
    ], [
      'phone.phone_valid' => "Le numéro de téléphone est invalide"
    ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param array $data
   * @return \App\Models\User
   */
  protected function create(array $data)
  {
    $phone = '';
    try {
      $phoneUtil = PhoneNumberUtil::getInstance();
      $swissNumber = $phoneUtil->parse($data['phone'], "MG");
      if ($phoneUtil->isValidNumber($swissNumber)) {
        $phone = $swissNumber->getNationalNumber();
      }
    } catch (NumberParseException $e) { }
    return User::create([
      'first_name' => $data['firstname'],
      'last_name' => $data['lastname'],
      'phone' => "0{$phone}",
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
    ]);
  }

  /**
   * The user has been registered.
   *
   * @param \Illuminate\Http\Request $request
   * @param mixed $user
   * @return mixed
   */
  protected function registered(Request $request, $user)
  {
    // Create customer data
    $customer = CustomerModel::create([
      'first_name' => $user->first_name,
      'last_name' => $user->last_name,
      'email' => $user->email,
      'id_user' => (int)$user->id_user
    ]);
  }
}
