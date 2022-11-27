<?php

namespace App\Http\Controllers;

use App\Models\CustomerBilling;
use App\Models\CustomerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $customers = CustomerModel::query()->get();
      return view("admin.customers", [
        'customers' => $customers
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

		public function shippingAddress(Request $request) {
			$val = Validator::make($request->all(), [
					'address' => "required",
				"phone" => "required",
				"zipcode" => "required",
				"region" => "nullable",
				"email" => "nullable",
				"city" => "required",
				"first_name" => "required",
				"last_name" => "required"
			]);

			if ($val->fails()) {
				return back()->with('error', $val->getMessageBag()->first());
			}
			$user_id = Auth::id();
			$customer = CustomerModel::query()->where('id_user', '=', $user_id)->first();
			$address = CustomerBilling::create([
					'id_customer' => $customer->id_customer,
				'address' => $request->get('address'),
				'phone' => $request->get('phone'),
				'zipcode' => $request->get('zipcode'),
				'city' => $request->get('city'),
				'email' => $request->get('email'),
				'first_name' => $request->get('first_name'),
				'last_name' => $request->get('last_name')
			]);
			return back()->with('info', "Address ajouté avec succès");
		}
}
