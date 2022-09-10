<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeModel extends Model
{
    use HasFactory;
    protected $table = "attributes";
    protected $primaryKey ="id_attribute";
    protected $fillable = [
      'id_group',
      'name'
    ];

    protected $casts = [
      'id_group' => 'integer'
    ];

}
