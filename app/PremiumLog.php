<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PremiumLog extends Model
{
	
	protected $fillable = ['user_id','periode','until','cost',];

}
