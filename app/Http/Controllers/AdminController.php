<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\OrderManager;
use App\Traits\ProductManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

class AdminController extends Controller
{
  use ProductManager, OrderManager;

  public function index()
  {
    return view("admin.dashboard", []);
  }

  public function employee_index()
  {
    $users = User::query()->where('group', "=", "admin")->get();
  }

  public function employee_created()
  {
    return;
  }

  public function employee_store(Request $request)
  {
    $validator = Validator::make($request->all(), array(
      "phone" => "required",
      "password" => "required",
      "first_name" => "required",
      "last_name" => "nullable",
      "email" => "nullable"
    ))->validate();
    try {
      $phoneUtil = PhoneNumberUtil::getInstance();
      $swissNumber = $phoneUtil->parse($request->get('phone'), "MG");
      if ($phoneUtil->isValidNumber($swissNumber)) {
        $phone = $swissNumber->getNationalNumber();
      }
      User::create([
        'first_name' => $request->get('first_name'),
        'last_name' => $request->get('last_name'),
        'phone' => "0{$phone}",
        'email' => $request->get('email', ''),
        "group" => "admin",
        'password' => Hash::make($request->get('password')),
      ]);
    } catch (NumberParseException $e) {
    }
  }
}
