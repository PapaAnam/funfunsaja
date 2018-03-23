<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;
use Storage;
use App\Content;
use App\Feedback;

class HomeController extends Controller
{
	public function setting()
	{
		$s = Setting::where('key', 'why_us')->first();
		
		return [
			'whyUs' => json_decode($s->value),
			'tentang' => $this->getTentang(),
		];
	}

	public function getTentang(){
		$tentang = Setting::where('key', 'tentang')->first();
		$tentang = collect(json_decode($tentang->value));
		$tentang = [
			'image_full_url' => asset('storage/'.$tentang['image'])
		]+$tentang->toArray();
		return $tentang;
	}

	public function getOurFocus(){
		$ur = Setting::where('key', 'our_focus')->first();
		$f = collect(json_decode($ur->value));
		$ur = collect($f['content'])->transform(function($item){
			return array_merge([
				'image_full_url' => asset('storage/'.$item->image)
			], collect($item)->toArray());
		});
		$f['content'] = $ur;
		return $f;
	}

	public function getWhyUs(){
		$ur = Setting::where('key', 'why_us')->first();
		$f = collect(json_decode($ur->value));
		return $f;
	}

	public function updateWhyUs(Request $r)
	{
		$r->validate([
			'why_us_desc_1' => 'required',
			'why_us_desc_2' => 'required',
			'why_us_desc_3' => 'required',
			'why_us_desc_4' => 'required',
			'why_us_icon_1' => 'required',
			'why_us_icon_2' => 'required',
			'why_us_icon_3' => 'required',
			'why_us_icon_4' => 'required',
			'why_us_title_1' => 'required',
			'why_us_title_2' => 'required',
			'why_us_title_3' => 'required',
			'why_us_title_4' => 'required',
		]);
		Setting::updateOrCreate([
			'key' => 'why_us'
		], [
			'value' => collect($r->except(['_method']))->toJson()
		]);
		return 'Kenapa memilih kami berhasil diperbarui';
	}

	public function updateTentang(Request $r)
	{
		$r->validate([
			'title' => 'required',
			'desc' => 'required',
		]);
		$s = $this->getTentang();
		$data['image'] = $s['image'];
		if($r->file('image')){
			if(Storage::exist('public/'.$s['image'])){
				Storage::delete('public/'.$s['image']);
			}
			$data['image'] = str_replace('public/', '', $r->file('image')->store('public/images'));
		}
		foreach(range(0,count($r->btn) - 1) as $i){
			$data['btn'][] = [
				'text' => $r->btn[$i],
				'link' => $r->link[$i]
			];
		}
		$sd = $data+$r->only('title', 'desc');
		Setting::updateOrCreate([
			'key' => 'tentang'
		], [
			'value' => collect($sd)->toJson()
		]);
		return 'Kenapa memilih kami berhasil diperbarui';
	}

	public function popularContent()
	{
		$popularContents = Content::with('kind')->take(6)->orderBy('hit', 'desc')->get()->map(function($item, $key){
			return collect($item)->only(['full_url', 'title', 'short_content', 'thumb']);
		});
		return $popularContents;
	}

	public function getTestimoni()
	{
		$testimoni = FeedBack::where('feedback_kind_id', 4)->take(10)->get()->map(function($item, $key){
			return collect($item)->only(['url', 'username', 'short_content', 'avatar']);
		});
		return $testimoni;
	}
}
