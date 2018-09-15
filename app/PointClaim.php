<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PointClaim extends Model
{
	protected $fillable = [
		'user_id', 'point', 'deposit_per_point',
		'min_point_ditukar',
		'point_yang_dipunya',
	] ;

	public function scopeMine($q, $user)
	{
		return $q->where('user_id', $user)->latest()->paginate(10);
	}
}
