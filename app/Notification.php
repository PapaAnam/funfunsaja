<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Notification extends Model
{

    // 0 itu member

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

    public function scopeMember($q)
    {
        return $q->where('to_type', '0');
    }

    public function usermember()
    {
        return $this->belongsTo('App\User', 'to_id');
    }
}
