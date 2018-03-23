<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['user_id', 'user_type', 'title', 'content',],
    $appends = ['is_member', 'username', 'user_role'];

    protected $casts = [
        'user_type' => 'int'
    ];

    public function scopeMyActivities($q, $user)
    {
    	return $q->where('user_id', $user)->latest()->paginate(10);
    }

    public function scopeGenerate($q, $title, $content, $user)
    {
    	return $q->create([
    		'title' 	=> $title,
    		'content'	=> $content,
    		'user_id'	=> $user
    	]);
    }

    public function admin()
    {
        return $this->belongsTo('App\Admin', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getIsMemberAttribute()
    {
        return $this->user_type == 0;
    }

    public function getUsernameAttribute()
    {
        return $this->user_type == 0 ? $this->user->username : $this->admin->username;
    }

    public function getUserRoleAttribute()
    {
        if($this->is_member){
            if($this->user->is_premium)
                return 'Member Premium';
            return 'Member';
        }
        if($this->admin->role === 'admin')
            return 'Admin';
        return 'Moderator';
    }
}
