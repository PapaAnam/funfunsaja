<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	public $timestamps = false;
	protected $guarded = [];

	public function scopeAbout($q)
	{
		$tentang = $q->where('key', 'tentang')->first();
		$tentang = collect(json_decode($tentang->value));
		$tentang = [
			'image_full_url' => asset('storage/'.$tentang['image'])
		]+$tentang->toArray();
		return (object) $tentang;
	}

	public function scopeOurFocus($q)
	{
		$ur = $q->where('key', 'our_focus')->first();
		$f = collect(json_decode($ur->value));
		$ur = collect($f['content'])->transform(function($item){
			return (object) array_merge([
				'image_full_url' => asset('storage/'.$item->image)
			], collect($item)->toArray());
		});
		$f['content'] = $ur;
		return (object) $f->toArray();
	}

	public function scopeWhyUs($q)
	{
		return (object) collect(json_decode(Setting::where('key', 'why_us')->first()->value))->toArray();
	}

	public function scopeWeb($q)
	{
		$web = $q->where('key', 'web')->first();
		if($web){
			$web = collect(json_decode($web->value))->transform(function($item, $key){
				if($key == 'logo' || $key == 'favicon')
					return substr($item, 0, 3) == 'pub' ? asset('storage/'.str_replace('public/', '', $item)) : asset('storage/'.$item);
				return $item;
			});
		}
		return (object) $web->toArray();
	}

	public function scopeFontType($q)
	{
		return $q->where('key', 'font')->first()->value;
	}

	public function scopePoint($q)
	{
		return collect(json_decode($q->firstOrCreate([
			'key' 	=> 'point'
		], [
			'value'	=> json_encode([
				'min' 	=> 1000,
				'get'	=> 10,
			])
		])->value))->toArray();
	}

	public function scopePointGet($q)
	{
		return $this->point()['get'];
	}

	public function scopeUpdatePoint($q, $data)
	{
		$q->updateOrCreate([
			'key'		=> 'point'
		], [
			'value'	=> json_encode($data)
		]);
	}

	public function scopeUpMember($q)
	{
		return collect(json_decode($q->firstOrCreate([
			'key'	=> 'up_member'
		], [
			'value'	=> json_encode([
				'one'		=> 30000,
				'three'		=> 80000,
				'six'		=> 150000,
				'twelve'	=> 280000,
			])
		])->value));
	}

	public function scopeUpdateUpMember($q, $data)
	{
		$q->updateOrCreate([
			'key'		=> 'up_member'
		], [
			'value'	=> json_encode($data)
		]);
	}
}
