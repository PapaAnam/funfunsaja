<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedBackKind extends Model
{
    protected $fillable = ['name', 'path'];
    public $timestamps = false;
    protected $appends = ['full_url'];
    protected $table = 'feedback_kinds';

    public function feedbacks()
    {
    	return $this->hasMany('App\Feedback', 'feedback_kind_id');
    }

    public function scopeSelectData($q)
    {
    	return $q->select(['name', 'id'])->orderBy('name')->get();
    }

    public function getFullUrlAttribute()
    {
        return url(str_replace('//', '/', '/feedback/'.$this->path));
    }
}
