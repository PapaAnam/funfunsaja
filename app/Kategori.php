<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'categories';
    public $timestamps = false;
    protected $guarded = [];

    public function contents()
    {
    	return $this->hasMany('App\Content', 'category_id');
    }

    public function scopeSelectData($q)
    {
    	return $q->select(['name', 'id'])->orderBy('name')->get();
    }
}
