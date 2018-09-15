<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PointClaim;
use App\Setting;
use App\Point;
use Auth;
use App\DepositTransaction;

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
		$point = $r->point;
		$pointCreate = PointClaim::create([
			'point'				=> $r->point,
			'deposit_per_point'	=> $r->result,
			'user_id'			=> $u->id,
			'min_point_ditukar'=>$sp['min'],
			'point_yang_dipunya'=>$u->point,
		]);
		$total 		 = $r->point * $r->result;
		$u->balance += $total;
		$u->point   -= $r->point;
		$u->save();
		$u->activities()->generate('Klaim Saldo', 'Melakukan klaim saldo sebesar '.$total.'', Auth::id());
		$dp = DepositTransaction::orderBy('no_tiket', 'desc')->first();
		$month = date('m');
		switch ($month) {
			case '01': $month = 'Januari'; break;
			case '02': $month = 'Februari'; break;
			case '03': $month = 'Maret'; break;
			case '04': $month = 'April'; break;
			case '05': $month = 'Mei'; break;
			case '06': $month = 'Juni'; break;
			case '07': $month = 'Juli'; break;
			case '08': $month = 'Agustus'; break;
			case '09': $month = 'September'; break;
			case '10': $month = 'Oktober'; break;
			case '11': $month = 'November'; break;
			case '12': $month = 'Desember'; break;
			default: $month = 'Tidak valid!!!'; break;
		}
		DepositTransaction::create([
			'no_tiket'=>is_null($dp) ? 1 : ++$dp->no_tiket,
			'user_id'=>$u->id,
			'deposit'=>$total,
			'jenis_transaksi'=>'Klaim saldo',
			'jumlah_disetujui'=>$total,
			'status'=>'By sistem',
			'tanggal_approve'=>date('Y-m-d'),
			'reason'=>'Penukaran poin sebanyak '.$point.' poin bulan '.$month.' '.date('Y'),
			'point_claim_id'=>$pointCreate->id,
		]);
		return 'Poin berhasil di klaim';
	}

}
