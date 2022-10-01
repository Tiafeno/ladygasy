<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class GuestModel extends Model
{
	use HasFactory;

	protected $table = "guest";
	protected $primaryKey = 'id_guest';
	protected $fillable = [
			'id_guest',
			'ip_address',
			'browser',
			'operating_system'
	];

	public static function getContext(): Model
	{
		$request = request();
		$ip = $request->ip();
		$browser = $request->header('User-Agent', 'Unknown');
		$system = $request->header('sec-ch-ua-platform', 'Unknown');
		if ($ip) {
			session()->put('lg_guest_session', Crypt::encryptString($ip));
			// verifier si le client guest exist déja
			$guest = static::query()->where('ip_address', '=', $ip)->first();
			if ($guest) {
				return $guest;
			} else {
				$guest = static::create([
						'ip_address' => $ip,
						'browser' => $browser,
						'operating_system' => $system
				]);
				return $guest;
			}
		} else {
			$ip_key = Str::uuid()->toString();
			session()->put('lg_guest_session', Crypt::encryptString($ip_key));
			$guest = static::create([
					'ip_address' => $ip_key,
					'browser' => $browser,
					'operating_system' => $system
			]);
			return $guest;
		}

	}
}
