<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateContent;
use App\Http\Requests\StoreContent;
use Illuminate\Http\Request;
use App\BoughtContent;
use App\ContentKind;
use App\Notification;
use App\Kategori;
use App\Activity;
use App\Content;
use App\User;
use Storage;
use App\Tag;
use App\DepositTransaction;
use Auth;

class ContentController extends Controller
{

	# START USER LOGIN

	public function index()
	{
		$contents 	= Content::withCount(['comments' => function($q){
			$q->where('status', '1');
		}])
		->where('user_id', Auth::id())->latest()->get();
		$oper 		= [
			'contents' 	=> $contents,
			'i' 		=> 1
		];
		return view('contents.index', $oper);
	}

	public function create()
	{
		$oper = [
			'contentKinds' => ContentKind::orderBy('name')->get(),
			'categories' => Kategori::orderBy('name')->get(),
			'tags' => Tag::orderBy('name')->get(),
		];
		return view('contents.create', $oper);
	}

	public function store(StoreContent $r)
	{
		$data = [];
		$att = $r->file('attachment');
		if($att){
			$data['attachment'] = str_replace('public/', '', $att->storeAs('public/'.$r->user()->username.('/attachment'), $att->getClientOriginalName()));
		}
		$thumb = $r->file('thumbnail');
		if($thumb){
			$data['thumbnail'] = str_replace('public/', '', $thumb->storeAs('public/'.$r->user()->username.('/thumbnail'), $thumb->getClientOriginalName()));
		}
		foreach ($r->tags as $t) {
			Tag::updateOrCreate([
				'name' => $t
			]);
		}
		$data['url'] = str_slug($r->title);
		$data['tags'] = $r->tags ? implode(',', $r->tags) : null;
		$data['user_id'] = Auth::id();
		Content::create($data+$r->only(['title', 'content_kind_id', 'category_id', 'content', 'type', 'status', 'fee']));
		$this->create_act($r->status);
		return $r->status == 'waiting' ? 'Konten berhasil dipublish. Menunggu persetujuan administrator' : 'Konten berhasil dimasukkan ke draft';
	}

	private function create_act($status)
	{
		Activity::create([
			'user_id'	=> Auth::id(),
			'title'		=> 'Buat Konten',
			'content'	=> $status == 'waiting' ? 'Mempublish konten ' : 'Membuat draft konten'
		]);
	}

	public function attachment($url)
	{
		$content = Content::where('url', $url)->first();
		return response()->download(storage_path('app/public/'.$content->attachment));
	}

	public function edit($url)
	{
		$content = Content::where('url', $url)->first();
		$c = $content;
		if($c->status == 'published' || $c->status == 'waiting')
			abort(404);
		if($c->user_id != Auth::id()){
			abort(404);
		}
		$data = $c->only(['id', 'title', 'content_kind_id', 'category_id', 'content', 'tags', 'type', 'fee', 'url']);
		$oper = [
			'data' => collect($data)->toJson(),
			'contentKinds' => ContentKind::selectData(),
			'categories' => Kategori::selectData(),
			'tags' => Tag::selectData(),
		];
		return view('contents.edit', $oper);
	}

	public function update($url, UpdateContent $r)
	{
		$c = Content::where('url', $url)->first();
		if($c->status == 'published' || $c->status == 'waiting' || $c->user_id != Auth::id()){
			abort(404);
		}
		$data = [];
		$att = $r->file('attachment');
		if($att){
			$file = 'public/'.$c->attachment;
			if(Storage::exists($file)){
				Storage::delete($file);
			}
			$data['attachment'] = str_replace('public/', '', $att->storeAs('public/'.$r->user()->username.('/attachment'), $att->getClientOriginalName()));
		}
		$thumb = $r->file('thumbnail');
		if($thumb){
			$file = 'public/'.$c->thumbnail;
			if(Storage::exists($file)){
				Storage::delete($file);
			}
			$data['thumbnail'] = str_replace('public/', '', $thumb->store('public/contents/thumbnail'));
		}
		$data['url'] = str_slug($r->title);
		$data['tags'] = $r->tags ? implode(',', $r->tags) : null;
		foreach ($r->tags as $t) {
			Tag::updateOrCreate([
				'name' => $t
			]);
		}
		$data['user_id'] = Auth::id();
		$c->update($data+$r->only(['title', 'content_kind_id', 'category_id', 'content', 'type', 'fee', 'status']));
		$this->create_act($r->status);
		return $r->status == 'waiting' ? 'Konten berhasil dipublish. Menunggu persetujuan administrator' : 'Konten berhasil dimasukkan ke draft';
	}

	public function delete(String $url)
	{
		$content = Content::where('url', $url)->first();
		$content->delete();
		Activity::create([
			'user_id'	=> Auth::id(),
			'title'		=> 'Hapus Konten',
			'content'	=> 'Menghapus konten'
		]);
		return 'Konten berhasil dihapus';
	}

	# END USER LOGIN

	public function contents()
	{
		$oper = [
			'ck' => ContentKind::data(),
		];
		return view('contents.contents', $oper);
	}

	public function all($content_kind_url, Request $r)
	{
		$ck = ContentKind::where('path', 'like', '%'.$content_kind_url.'%')->first();
		$contents = [];
		$user = 'all';
		$cat = 'all';
		if($ck){
			$contents = $ck->contents()->withCount(['comments' => function($q){
				$q->where('status', '1');
			}])->with('cat')->where('status', 'published');
			if($r->query('user') && $r->query('user') != 'all'){
				$user_id = User::where('username', $r->query('user'))->first()->id;
				$contents = $contents->where('user_id', $user_id);
				$user = $r->query('user');
			}
			if($r->query('cat') && $r->query('cat') != 'all'){
				$cat_id = Kategori::where('url', $r->query('cat'))->first()->id;
				$contents = $contents->where('category_id', $cat_id);
				$cat = $r->query('cat');
			}	
			$keyword = $r->query('keyword');
			if($keyword)
				$contents = $contents->where(function($q) use($keyword){
					$q->where('title', 'like', '%'.$keyword.'%')
					->orWhere('content', 'like', '%'.$keyword.'%');
				})->latest()->paginate(10);	
			else
				$contents = $contents->latest()->paginate(10);
		}
		$oper = [
			'data' 			=> $contents,
			'users' 		=> User::username(),
			'categories' 	=> Kategori::orderBy('name')->get(),
			'modul' 		=> $ck ? $ck->name : '',
			'url' 			=> $content_kind_url,
			'user' 			=> $user,
			'cat' 			=> $cat,
		]+$this->getRightMenu();
		return view('contents.all', $oper);
	}

	private function getRightMenu()
	{
		$ck = ContentKind::withCount(['contents' => function($q){
			$q->where('status', 'published');
		}])->orderBy('name')->get();
		$count = 7;
		$populars = Content::with('kind')->where('status', 'published')->take($count)->orderBy('title')->orderBy('hit', 'DESC')->get();
		$newest = Content::with('kind')->where('status', 'published')->take($count)->latest()->get();
		$random = Content::with('kind')->where('status', 'published')->take($count)->inRandomOrder()->get();
		return [
			'content_kinds' => $ck,
			'populars'		=> $populars,
			'newest'		=> $newest,
			'random'		=> $random,
		];
	}

	public function detail($content_kind_url, $url)
	{
		$content = Content::where('url', $url)->first();
		$ck = ContentKind::where('path', 'like', '%'.$content_kind_url.'%')->first();
		if(!$ck)
			abort(404);
		if(!$content)
			abort(404);
		if($content->status == 'published'){
			$content->increment('hit');
			$oper = [
				'modul'		=> $ck->name,
				'content' 	=> Content::with(['comments' => function($q){
					$q->with('user')->where('status', '1')->orderBy('is_best', 'desc')->orderBy('created_at', 'desc');
				}, 'cat',])->withCount(['comments' => function($q){
					$q->where('status', '1');
				}])->where('id', $content->id)->first()
			]+$this->getRightMenu();
			return view('contents.detail', $oper);
		}
		return abort(404);
	}

	public function alert($ck, $url)
	{
		$ck = ContentKind::where('path', 'like', '%'.$ck)->first();
		$content = Content::where('url', $url)->with('user')->first();
		$oper = [
			'content' 	=> $content,
			'modul'		=> $ck->name,
		];
		return view('contents.confirm', $oper);
	}

	public function buy(Request $r)
	{
		$user 		= $r->user();
		$content 	= Content::where('url', $r->content)->first();
		$bc 		= BoughtContent::where('user_id', $user->id)->where('content_id', $content->id);
		if($bc->count() > 0){
			return redirect()->route('contents.detail', [$r->ck, $content->url]);
		}
		$fee = $content->fee;
		if($user->is_premium)
			$fee /= 2;
		$user->balance -= $fee;
		$user->save();

		$author = $content->user()->first();
		$author->balance += (70 / 100 * $fee);
		$author->save();

		$bought = BoughtContent::create([
			'user_id'		=> $user->id,
			'content_id'	=> $content->id,
			'price'			=> $fee,
		]);

		Activity::create([
			'user_id'	=> Auth::id(),
			'title'		=> 'Pembelian Konten',
			'content'	=> 'Membeli konten premium dengan judul '.$content->title,
		]);
		$dp = DepositTransaction::orderBy('no_tiket', 'desc')->first();
		DepositTransaction::create([
			'no_tiket'=>is_null($dp) ? 1 : ++$dp->no_tiket,
			'user_id'=>$user->id,
			'deposit'=>$fee,
			'jenis_transaksi'=>'Pembelian konten',
			'jumlah_disetujui'=>$fee,
			'status'=>'By sistem',
			'tanggal_approve'=>date('Y-m-d'),
			'reason'=>'Konten <a href="'.$content->full_url.'">'.$content->title.'</a>',
			'premium_content_id'=>$bought->id,
		]);
		$dp = DepositTransaction::orderBy('no_tiket', 'desc')->first();
		DepositTransaction::create([
			'no_tiket'=>is_null($dp) ? 1 : ++$dp->no_tiket,
			'user_id'=>$content->user_id,
			'deposit'=>$fee,
			'jenis_transaksi'=>'Penjualan konten',
			'jumlah_disetujui'=>$fee,
			'status'=>'By sistem',
			'tanggal_approve'=>date('Y-m-d'),
			'reason'=>'Konten <a href="'.$content->full_url.'">'.$content->title.'</a>',
			'premium_content_id'=>$bought->id,
		]);
		$oper = [
			'content'	=> $content,
			'modul'		=> $r->ck,
		];
		return view('contents.success', $oper);
	}

	public function withCategory($cat)
	{
		if(Kategori::where('url', 'like', '%'.$cat.'%')->count()){
			$c = Kategori::where('url', 'like', '%'.$cat.'%')->first();
			$contents = Content::with('kind', 'user')->withCommentCount()->published()->where('category_id', $c->id)->latest()->paginate(10);
			return view('contents.all-by-category', [
				'contents'	=> $contents,
				'cat'		=> $c->name,
			]+$this->getRightMenu());
		}
		abort(404);
	}

	public function withTag($tag)
	{
		$contents = Content::with('kind', 'user', 'cat')->withCommentCount()->published()->where('tags', 'like', '%'.$tag.'%')->latest()->paginate(10);
		return view('contents.all-by-tag', [
			'contents'	=> $contents,
			'tag'		=> $tag,
		]+$this->getRightMenu());
	}
}
