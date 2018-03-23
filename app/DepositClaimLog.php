<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepositClaimLog extends Model
{
	protected $fillable = ['user_id', 'deposit', 'status'];
	protected $appends 	= ['is_verified'];
	protected $casts 	= [
		'is_verified'	=> 'boolean',
	];

	protected function getIsVerifiedAttribute()
	{
		return $this->status === '1';
	}

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}
}
