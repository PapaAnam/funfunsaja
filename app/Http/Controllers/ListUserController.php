<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\ContentKind;
use App\Content;
use DB;

class ListUserController extends Controller
{

	public function index(Request $r)
	{
		$keyword = $r->query('keyword');
		$users = User::with([
				'bio'	=> function($q){
					$q->where('status', '1');
				},
			]);
		if($keyword)
			$users = $users->where(function($q) use($keyword){
				$q->where('username', 'like', '%'.$keyword.'%')
				->orWhere('email', 'like', '%'.$keyword.'%')
				->orWhere('description', 'like', '%'.$keyword.'%');
			})->withCount('contents')->latest()->paginate(10);	
		else
			$users = $users->withCount(['contents' => function($q){
				$q->published();
			}])->latest()->paginate(10);
		$oper = [
			'data'	=> $users
		]+$this->getRightMenu();
		return view('all-user.all', $oper);
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

	public function profile($username)
	{
		if(User::where('username', $username)->count() <= 0)
			abort(404);
		$user = User::where('username', $username)->first();
		return view('user_profile.view', [
			'user'				=> $user,
			'contents_count'	=> Content::where('user_id', $user->id)->published()->count(),
			'contents'			=> Content::where('user_id', $user->id)->published()->take(10)->latest()->get(),
		]+$this->getRightMenu());
	}

}
