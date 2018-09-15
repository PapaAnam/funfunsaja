<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DepositTransaction;

class UpgradeMemberController extends Controller
{

	public function index(Request $r)
	{
		$data = [
			'today'=>[],
			'other'=>[],
		];
		if($r->date == 'today'){
			$data['today'] = DepositTransaction::with('user','upgrademember')->where('jenis_transaksi', 'Upgrade member')
			->where('created_at', 'LIKE', date('Y-m-d').'%')
			->latest()->get();	
		}else{
			$data['today'] = DepositTransaction::with('user','upgrademember')->where('jenis_transaksi', 'Upgrade member')
			->where('created_at', 'LIKE', date('Y-m-d').'%')
			->latest()->get();	
			$thn = substr($r->date, 0, 4);
			$bln = substr($r->date, 5, 2);
			$data['other'] = DepositTransaction::with('user','upgrademember')->where('jenis_transaksi', 'Upgrade member')
			->whereMonth('created_at', $bln)
			->whereYear('created_at', $thn)
			->latest()->get();	
		}
		return $data;
	}

}
