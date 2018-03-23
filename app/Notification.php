<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Notification extends Model
{
    protected $guarded = [];

    public function scopeMyNotifCount($q)
    {
    	$count = $q->where('to_type', '0')->where('to_id', Auth::id())->where('status', '0')->count();
    	return $count;
    }

    public function scopeMyNotif($q, $user)
    {
    	return $q->where('to_type', '0')->where('to_id', $user)->latest()->paginate(10);
    }

    public function scopeWatched($q)
    {
    	$q->where('to_type', '0')->where('to_id', Auth::id())->update([
    		'status' => '1'
    	]);
    }
}
