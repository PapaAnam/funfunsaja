<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DepositTransaction;

class FeeKontenController extends Controller
{

	public function index(Request $r)
	{
		$data = [
			'today'=>[],
			'other'=>[],
		];
		if($r->date == 'today'){
			$data['today'] = DepositTransaction::with('user','kontenpremium.content')
			->where('jenis_transaksi', 'Penjualan konten')
			->where('created_at', 'LIKE', date('Y-m-d').'%')
			->latest()->get();	
		}else{
			$data['today'] = DepositTransaction::with('user','kontenpremium.content')
			->where('jenis_transaksi', 'Penjualan konten')
			->where('created_at', 'LIKE', date('Y-m-d').'%')
			->latest()->get();	
			$thn = substr($r->date, 0, 4);
			$bln = substr($r->date, 5, 2);
			$data['other'] = DepositTransaction::with('user','kontenpremium.content')
			->where('jenis_transaksi', 'Penjualan konten')
			->whereMonth('created_at', $bln)
			->whereYear('created_at', $thn)
			->latest()->get();	
		}
		return $data;
	}

}
