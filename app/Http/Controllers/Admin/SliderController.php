<?php

namespace App\Http\Controllers\Admin;

use Storage;
use App\Slider;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSlider;
use App\Http\Requests\UpdateSlider;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
	public function api()
	{
		$this->clear();
		return Slider::all();
	}

	public function active()
	{
		return Slider::where('status', '1')->get();
	}

	public function store(StoreSlider $r)
	{
		$image = $r->file('image')->store('public/sliders');
		$data = [
			'image' => str_replace('public/', '', $image)
		];
		Slider::create($data+$r->all());
		return response('Slider berhasil ditambahkan');
	}

	public function update($id, UpdateSlider $r)
	{
		$data = [];
		$slider = Slider::find($id);
		if($r->file('image')){
			if($slider->image){
				Storage::delete('public/'.$slider->image);
			}
			$image = $r->file('image')->store('public/sliders');
			$data = [
				'image' => str_replace('public/', '', $image)
			];	
		}
		$slider->update($data+$r->all());
		return response('Slider berhasil diperbarui');
	}

	public function delete($id)
	{
		Slider::find($id)->delete();
		return response('Slider berhasil dihapus');
	}

	public function clear()
	{
		$files = collect(Storage::files('public/sliders'))->transform(function($item){
			return str_replace('public/sliders/', '', $item);
		});
		$files->each(function($item){
			if(Slider::where('image', 'LIKE', '%'.$item.'%')->count() == 0){
				Storage::delete('public/sliders/'.$item);
			}
		});
	}
}
