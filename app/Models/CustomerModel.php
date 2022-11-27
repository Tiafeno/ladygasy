<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CustomerModel extends Model
{
    use HasFactory;
    protected ?Model $user = null;
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
      if ($this->user instanceof Model) return $this->user;
      $this->user = User::query()->find($this->id_user);
      if ($this->user) return $this->user;
      return null;
    }

	public static function getContext(): ?static {
		$current_user = Auth::user();
		if (!$current_user) return null;
		$customer = static::query()->where('id_user', '=', Auth::id())->first();
		if ($customer) return $customer;
		return null;
	}
}
