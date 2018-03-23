<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePage;
use App\Http\Requests\StorePage;
use Illuminate\Http\Request;
use App\PageKind;
use App\Kategori;
use App\Setting;
use App\Page;
use App\Tag;
use Storage;
use App\Helpers\Api;
use DB;

class PageController extends Controller
{
	use Api;

	protected function model(){
		return new Page();
	}

	public function single($id)
	{
		return Page::find($id);
	}

	public function store(StorePage $r)
	{
		$data = [];
		$att = $r->file('attachment');
		if($att){
			$data['attachment'] = str_replace('public/', '', $att->storeAs('public/pages/attachment', $att->getClientOriginalName()));
		}
		$thumb = $r->file('thumbnail');
		if($thumb){
			$data['thumbnail'] = str_replace('public/', '', $thumb->store('public/pages/thumbnail'));
		}
		$data['url'] = str_slug($r->title);
		foreach($r->tags as $t){
			Tag::updateOrCreate([
				'name' => $t
			], [
				'url' => str_slug($t)
			]);
		}
		$data['tags'] = $r->tags ? implode(',', $r->tags) : null;
		Page::create($data+$r->all());
		return $r->status == '1' ? 'Halaman berhasil dipublish.' : 'Halaman berhasil dimasukkan ke draft';
	}

	public function edit($id)
	{
		$oper = [
			'data' => Page::find($id),
			'pageKinds' => PageKind::select(['id', 'name'])->orderBy('name')->get(),
			'categories' => Kategori::select(['id', 'name'])->orderBy('name')->get(),
			'tags' => Tag::select(['name'])->orderBy('name')->get(),
		];
		return view('admin.pages.edit', $oper);
	}

	public function update($id, UpdatePage $r)
	{
		$data = [];
		$page = Page::find($id);
		$att = $r->file('attachment');
		if($att){
			Storage::delete('public/'.$page->attachment);
			$data['attachment'] = str_replace('public/', '', $att->storeAs('public/pages/attachment', $att->getClientOriginalName()));
		}
		$thumb = $r->file('thumbnail');
		if($thumb){
			Storage::delete('public/'.$page->thumbnail);
			$data['thumbnail'] = str_replace('public/', '', $thumb->store('public/pages/thumbnail'));
		}
		$data['url'] = str_slug($r->title);
		foreach($r->tags as $t){
			Tag::updateOrCreate([
				'name' => $t
			], [
				'url' => str_slug($t)
			]);
		}
		$data['tags'] = $r->tags ? implode(',', $r->tags) : null;
		$page->update($data+$r->only(['title', 'content', 'page_kind_id', 'category_id', 'status']));
		return $r->status == '1' ? 'Halaman berhasil dipublish.' : 'Halaman berhasil dimasukkan ke draft';
	}

	public function attachment($url)
	{
		$content = Page::where('url', $url)->first();
		return response()->download(storage_path('app/public/'.$content->attachment));
	}

	public function delete($id)
	{
		if(Page::find($id)->delete()){
			return 'Halaman berhasil dihapus.';
		}
		return response('gagal', 500);
	}
}
