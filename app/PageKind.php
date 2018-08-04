<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageKind extends Model
{
    protected $fillable = ['name', 'path'];
    protected $appends = ['link'];
    public $timestamps = false;

    public function pages()
    {
    	return $this->hasMany('App\Page', 'page_kind_id');
    }

    public function getLinkAttribute()
    {
    	return url('pages/'.str_replace('/', '', $this->path));
    }

}
