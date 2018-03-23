<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $fillable = ['point', 'user_id', 'description', 'content_id'];

    public function scopeMyPoints($q, $user)
    {
    	return $q->with('content.kind')->where('user_id', $user)->latest()->paginate(10);
    }

    public function content()
    {
    	return $this->belongsTo('App\Content');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
