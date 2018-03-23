<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentKind extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'path'];
    protected $appends = ['full_url'];

    public function contents()
    {
    	return $this->hasMany('App\Content', 'content_kind_id');
    }

    public function scopeSelectData($q)
    {
    	return $q->select(['name', 'id'])->orderBy('name')->get();
    }

    public function scopeData($q)
    {
        return $q->orderBy('name')->get();
    }

    public function getFullUrlAttribute()
    {
        return url(str_replace('//', '/', '/contents/'.$this->path));
    }
}
