<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Setting;

class Menu extends Model
{
	protected $guarded = [];
	public $timestamps = false;
	protected $appends = ['name_view', 'link'];

	public function sm()
	{
		return $this->hasMany('App\Menu', 'primary_menu');
	}

	public function scopeUtama($q)
	{
		return $q->with('sm')->where('primary_menu', null)->orderBy('position')->get();
	}

	public function scopeSubMenu($q, $id)
	{
		return $q->where('primary_menu', $id)->orderBy('position')->get();
	}

	public function m()
	{
		return $this->belongsTo('App\Menu', 'primary_menu');
	}

	public function getNameViewAttribute()
	{
		$font_type = Setting::where('key', 'font')->first()->value;
		if($font_type == 'uppercase'){
			return strtoupper($this->name);
		}else if($font_type == 'lowercase'){
			return strtolower($this->name);
		}
		return ucwords($this->name);
	}

	public function getLinkAttribute()
	{
		return url($this->url);
	}
}
