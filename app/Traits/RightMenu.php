<?php 

namespace App\Traits;

use App\User;
use App\ContentKind;
use App\Content;

trait RightMenu {
	
	protected function getRightMenu()
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

}