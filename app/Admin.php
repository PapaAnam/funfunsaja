<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
	use Notifiable;

	protected $guarded = [];

	protected $hidden = ['password', 'remember_token'];

	public function activities()
    {
        return $this->hasMany('App\Activity', 'user_id');
    }
}
