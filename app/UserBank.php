<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBank extends Model
{
    protected $table = 'user_bank_accounts';
    protected $guarded = [];

    public function scopeActive($q)
    {
    	return $q->where('status', '1');
    }
}
