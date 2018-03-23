<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PointClaim;
use App\Setting;
use App\Point;
use Auth;

class PointController extends Controller
{

	public function index()
	{
		$points 	= Point::myPoints(Auth::id());
		$oper 			= [
			'points'		=> $points,
			'ps'			=> Setting::point(),
			'histories'		=> PointClaim::mine(Auth::id()),
		];
		return view('points.index', $oper);
	}

	public function claim(Request $r)
	{
		$sp = Setting::point();
		$r->validate([
			'point'	=> 'required|numeric|min:'.$sp['min']
		]);
		$u = $r->user();
		if($u->point < $r->point)
			return response([
				'errors' => [
					'point' => [
						'Poin tidak valid',
					]
				]
			], 422);
		PointClaim::create([
			'point'				=> $r->point,
			'deposit_per_point'	=> $r->result,
			'user_id'			=> $u->id,
		]);
		$total 		 = $r->point * $r->result;
		$u->balance += $total;
		$u->point   -= $r->point;
		$u->save();
		$u->activities()->generate('Klaim Saldo', 'Melakukan klaim saldo sebesar '.$total.'', Auth::id());
		return 'Poin berhasil di klaim';
	}

}
