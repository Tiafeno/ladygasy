<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    use HasFactory;
    protected $table = 'customer';
    protected $primaryKey = "id_customer";
    protected $fillable = [
      'id_user',
      'first_name',
      'last_name',
      'email',
      'city',
      'region',
      'gender'
    ];

    protected $casts = [
      'id_user' => 'integer'
    ];

    public function getUser(): ?Model {
      $user = User::query()->find($this->id_user);
      if ($user) return $user;
      return null;
    }
}
