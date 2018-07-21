<?php

namespace App\Traits;
use App\Content;

trait UserOper
{
	
	protected function useroper($r)
	{
		$user = $r->user();
		$oper = [
			'user'	=> $user,
			'contents_count'	=> Content::where('user_id', $user->id)->published()->count(),
		]+$this->getRightMenu();
		return $oper;
	}

}