<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Content;

class ContentController extends Controller
{
   
    private function getToday()
	{
		return Content::with('kind', 'user')->where('created_at', 'LIKE', date('Y-m-d').'%')->latest()->get();
	}

	private function getOther($year, $month)
	{
		return Content::with('kind', 'user')->where('created_at', 'LIKE', date($year.'-'.$month).'%')->latest()->get();
	}

	public function today()
	{
		return [
			'today' => $this->getToday(),
			'other'	=> [],
		];
	}

	public function filter($year, $month)
	{
		return [
			'today' => $this->getToday(),
			'other'	=> $this->getOther($year, $month),
		];
	}
}
