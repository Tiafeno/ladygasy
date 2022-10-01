<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
  use HasFactory;
  protected $primaryKey = "id_product_attribute";
  protected $table = "product_attribute";
  protected $fillable = [
    'id_product',
    'name',
    'reference',
    'ean13',
    'quantity',
    'default_on',
    'price'
  ];
}
