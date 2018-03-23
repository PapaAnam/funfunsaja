<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\PageKind;
use App\Kategori;
use DB;
// use App\Helpers\Api;

class PageController extends Controller
{

	

	private function getRightMenu()
	{
		$pk = PageKind::withCount(['pages' => function($q){
			$q->where('status', '1');
		}])->orderBy('name')->get();
		$count = 7;
		$populars = Page::with('kind')->where('status', '1')->take($count)->orderBy('title')->orderBy('hit', 'DESC')->get();
		$newest = Page::with('kind')->where('status', '1')->take($count)->latest()->get();
		$random = Page::with('kind')->where('status', '1')->take($count)->inRandomOrder()->get();
		return [
			'page_kinds' 	=> $pk,
			'populars'		=> $populars,
			'newest'		=> $newest,
			'random'		=> $random,
		];
	}

	public function all($page_kind_url, Request $r)
	{
		$pk = PageKind::where('url', '/pages/'.$page_kind_url)->first();
		$pages = $pk->pages()->with('cat')->where('status', '1');
		$cat = 'all';
		if($r->query('cat') && $r->query('cat') != 'all'){
			$cat_id = Kategori::where('url', $r->query('cat'))->first()->id;
			$pages = $pages->where('category_id', $cat_id);
			$cat = $r->query('cat');
		}
		$keyword = $r->query('keyword');
		if($keyword)
			$pages = $pages->where(function($q) use($keyword){
				$q->where('title', 'like', '%'.$keyword.'%')
				->orWhere('content', 'like', '%'.$keyword.'%');
			});	
		$oper = [
			'data' 			=> $pages->latest()->paginate(10),
			'categories' 	=> Kategori::orderBy('name')->get(),
			'modul' 		=> $pk->name,
			'url' 			=> $page_kind_url,
			'cat' 			=> $cat,
		]+$this->getRightMenu();
		return view('pages.all', $oper);
	}

	public function detail($pk_url, $url)
	{
		$pk = PageKind::whereUrl('/pages/'.$pk_url)->first();
		if(!$pk)
			abort(404);
		$page = Page::where('url', $url)->where('page_kind_id', $pk->id)->first();
		if(!$page)
			abort(404);
		if($page->status == '1'){
			Page::where('url', $url)->increment('hit');
			$oper = [
				'page' => $page,
				'modul' => $pk->name
			]+$this->getRightMenu();
			return view('pages.detail', $oper);
		}
		return abort(404);
	}
}
