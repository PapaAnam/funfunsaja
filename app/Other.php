<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Other extends Model
{
	protected $guarded = [];
    // public $timestamps = false;

	public function scopeCr($q, $data, $cat)
	{
		foreach($data as $d){
			if($q->where([
				'name' => trim($d),
				'category' => trim($cat)
			])->count() <= 0){
				$q->create([
					'name' => trim($d),
					'category' => trim($cat)
				]);
			}
		}
	}
}
