<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageKind extends Model
{
    protected $fillable = ['name', 'path'];
    public $timestamps = false;

    public function pages()
    {
    	return $this->hasMany('App\Page', 'page_kind_id');
    }

}
