<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $guarded = [];

	public function scopeSelectData($q)
	{
		return $q->select('name')->orderBy('name')->get();
	}


	public function scopeCr($q, $r)
	{
		foreach ($r->tags as $t) {
			$q->updateOrCreate([
				'name' => $t
			]);
		}
	}
}
