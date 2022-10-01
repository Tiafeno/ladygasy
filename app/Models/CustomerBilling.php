<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBilling extends Model
{
    use HasFactory;
		protected $table = "customer_billing";
		protected $primaryKey = "id_billing";
		protected $fillable = [
				'id_customer',
			'id_zone',
			'address',
			'phone',
			'zipcode',
			'region',
			'city',
			'first_name',
			'last_name',
		];



}
