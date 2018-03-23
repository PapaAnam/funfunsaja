<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepositTransaction extends Model
{
	protected $table = 'deposits';
	protected $guarded = [];
	protected $appends = ['crat', 'depo_view'];

	public function getCratAttribute()
	{
		$month = substr($this->created_at, 5, 2);
		switch ($month) {
			case '01': $month = 'Januari'; break;
			case '02': $month = 'Februari'; break;
			case '03': $month = 'Maret'; break;
			case '04': $month = 'April'; break;
			case '05': $month = 'Mei'; break;
			case '06': $month = 'Juni'; break;
			case '07': $month = 'Juli'; break;
			case '08': $month = 'Agustus'; break;
			case '09': $month = 'September'; break;
			case '10': $month = 'Oktober'; break;
			case '11': $month = 'November'; break;
			case '12': $month = 'Desember'; break;
			default: $month = 'Tidak valid!!!'; break;
		}
		return substr($this->created_at, 8, 2).' '.$month.' '.substr($this->created_at,0,4).' '.substr($this->created_at, 11);
	}

	public function getDepoViewAttribute()
	{
		return number_format($this->deposit, 0, ',', '.');
	}

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function bank()
	{
		return $this->belongsTo('App\BankAccount', 'receiver');
	}

	public function scopeDashboard($q)
	{
		return $q->with('user')->where('status', '0')->take(5)->latest()->get();
	}

	public function scopeMine($q, $user)
	{
		return $q->where('user_id', $user)->latest()->paginate(10);
	}

}
